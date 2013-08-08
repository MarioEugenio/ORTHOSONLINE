<?php

namespace Orthos\Bundle\AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard/agenda/listaDiaria")
     * @template()
     */
    public function dashboardListaDiariaAction () {

        $result = $this->get('Orthos.AgendaBusiness')->getPacientePorData(
            date('d/m/Y')
        );

        return array(
            'list' => json_encode($result)
        );
    }

    /**
     * @Route("/orthos/agenda", name="Orthos_Agenda", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
        $clinica = $this->get('Orthos.ClinicaBusiness')->findAll(FALSE);

        return array(
            'clinicas' => json_encode($clinica)
        );
    }

    /**
     * @Route("/orthos/agendar", name="Orthos_Agendar", options={"expose"=true})
     * @Template()
     */
    public function agendarAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/observacao", name="Orthos_Agenda_Observacao", options={"expose"=true})
     * @Template()
     */
    public function observacaoAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/remover", name="Orthos_Agenda_Remover", options={"expose"=true})
     * @Template()
     */
    public function removerAction()
    {
        return array();
    }
}
