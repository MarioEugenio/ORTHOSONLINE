<?php

namespace Orthos\Bundle\NewslatterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ModeloDocumentoController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\NewslatterBundle\Business\ModeloDocumentoBusiness';

    /**
     * @Route("/orthos/modeloDocumento")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/modeloDocumento/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/modeloDocumento/save")\
     */
    public function saveAction () {
        try {
            $form = $this->getRequestJson();
            $entity = new \Orthos\Bundle\NewslatterBundle\Entity\ModeloDocumento($form);

            $this->getBusiness()->save($entity);

            return $this->responseMessage("Cadastro realizado com sucesso", TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/modeloDocumento/list")\
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
