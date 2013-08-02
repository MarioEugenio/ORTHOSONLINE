<?php

namespace Orthos\Bundle\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MediaController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\MediaBundle\Business\ImagemBusiness';


    const IMG_FORMAT = "jpg";
    const IMG_SIZE = "120x120";

    /**
     * @Route("/orthos/media", name="media_upload")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }


    /**
     * @Route("/orthos/media/upload")
     */
    public function uploadAction()
    {
        try {

        $request = $this->getRequest();
        $destination = preg_replace('/app$/si', 'web' . $request->request->get('folder'), $this->get('kernel')->getRootDir());
        $destination = $destination.'/uploads/tmp/';

        $targetFolder = $destination; // Relative to the root

        $sqPaciente = ($this->getRequest()->get('sqPaciente'));
        /** @var $business \Orthos\Bundle\PacienteBundle\Business\PacienteBusiness */
        $business = $this->get('Orthos.PacienteBusiness');

        /** @var $paciente \Orthos\Bundle\ClinicaBundle\Entity\Paciente */
        $paciente = $business->find($sqPaciente);

        if ($paciente) {
            if (!empty($_FILES) ) {
                $tempFile = $_FILES['Filedata']['tmp_name'];
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
                $targetFile =  $_FILES['Filedata']['name'];
                // Validate the file type
                $fileTypes = array('jpg','jpeg','gif','png','JPEG'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);

                //if (in_array($fileParts['extension'],$fileTypes)) {

                    $name = 'IMG'.time().$paciente->getNuMatricula().$targetFile;
                    $file = $destination . $name;
                    move_uploaded_file($tempFile,$file);

                    $entity = new \Orthos\Bundle\MediaBundle\Entity\Imagem();
                    $entity->setSqPaciente($paciente);
                    $entity->setNoArquivo($name);
                    $entity->setDtCadastro(new \DateTime());
                    $business->getModel()->getEntityManager()->persist($entity);
                    $business->getModel()->getEntityManager()->flush();

                    return $this->responseJson(
                        array(
                            "success" => true,
                            "title" => 'AVISO',
                            "message" => 'Executado com sucesso',
                            "result" => $entity->toArray()
                        ));
               /* } else {
                    return $this->responseJson(
                        array(
                            "success" => false,
                            "title" => 'AVISO',
                            "message" => 'Formato de arquivo inválido',
                            "result" => NULL
                        ));
                }*/
            }
        } else {

            return $this->responseJson(
                array(
                    "success" => false,
                    "title" => 'AVISO',
                    "message" => 'Usuário não encontrado.',
                    "result" => NULL
                ));
        }

        } catch (\Exception $exc) {
            return $this->responseJson(
                array(
                    "success" => false,
                    "title" => 'AVISO',
                    "message" => $exc->getMessage(),
                    "result" => NULL
                ));
        }

        return $this->responseJson(
            array(
                "success" => false,
                "title" => 'AVISO',
                "message" => 'Ocorreu um erro ao executar o processo.',
                "result" => NULL
            ));
    }
}
