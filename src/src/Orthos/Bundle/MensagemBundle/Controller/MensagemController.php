<?php

namespace Orthos\Bundle\MensagemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MensagemController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\MensagemBundle\Business\MensagemBusiness';


    /**
     * @Route("/orthos/mensagem")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/mensagem/list/{paciente}")
     */
    public function listMensagensAction ($paciente) {
        $result = $this->getBusiness()->findBy(FALSE, array (
            'sq_paciente' => $this->get('Orthos.PacienteBusiness')->find($paciente)
        ));

        return $this->responseJson($result);
    }

    /**
     * @Route("/orthos/mensagem/enviar")
     */
    public function enviarAction () {
        try {
            $form = $this->getRequestJson();

            $entity = new \Orthos\Bundle\MensagemBundle\Entity\Mensagem($form);
            $entity->setSqPaciente(
                $this->get('Orthos.PacienteBusiness')->find($form['sq_paciente'])
            );

            $this->getBusiness()->save($entity);

            return $this->responseMessage('Envio realizado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }
}
