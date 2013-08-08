<?php

namespace Orthos\Bundle\NewslatterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewslatterController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\NewslatterBundle\Business\NewslatterBusiness';

    /**
     * @Route("/orthos/newslatter")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/newslatter/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        return array(
            'listModeloDocumento' => json_encode(
                $this->get('Orthos.ModeloDocumentoBusiness')->findAll(FALSE)
            ),
            'listPaciente' => json_encode(
                $this->get('Orthos.PacienteBusiness')->getPacienteNewsllater()
            )
        );
    }

    /**
     * @Route("/orthos/newslatter/save")\
     */
    public function saveAction () {
        try {
            $form = $this->getRequestJson();
            $entity = new \Orthos\Bundle\NewslatterBundle\Entity\Newslatter($form);

            if (isset($form['sqModeloDocumento'])) {
                $entity->setSqModeloDocumento(
                    $this->get('Orthos.ModeloDocumentoBusiness')->find($form['sqModeloDocumento'])
                );
            }

            $this->getBusiness()->save($entity);

            return $this->responseMessage("Cadastro realizado com sucesso", TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/newslatter/list")\
     */
    public function listAction () {


        $return = $this->getBusiness()->findAll(FALSE);

        if (!$return) {
            $return = array();
        }

        return $this->responseJson(
            json_encode($return)
        );
    }
}
