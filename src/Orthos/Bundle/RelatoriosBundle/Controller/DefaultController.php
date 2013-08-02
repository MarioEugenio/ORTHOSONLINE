<?php

namespace Orthos\Bundle\RelatoriosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/relatorio/financeiro/baixas")
     * @Template()
     */
    public function baixasAction()
    {
        return array();
    }

    /**
     * @Route("/relatorio/financeiro/parcelas")
     * @Template()
     */
    public function parcelasAction()
    {
        return array();
    }

    /**
     * @Route("/relatorio/financeiro/receita")
     * @Template()
     */
    public function receitaAction()
    {
        return array();
    }

    /**
     * @Route("/relatorio/financeiro/inadimplencia")
     * @Template()
     */
    public function inadimplenciaAction()
    {
        /** @var $pacienteStatus \Orthos\Bundle\ClinicaBundle\Business\PacienteStatusBusiness */
        $pacienteStatus = $this->get('Orthos.PacienteStatusBusiness');

        return array(
            'list' => $pacienteStatus->getAllPacienteStatus()
        );
    }
}
