<?php

namespace Orthos\Bundle\RelatoriosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class FinanceiroController extends \abstraction\controller\AbstractController
{
    /**
     * @Route("/relatorio/bind/financeiro/baixas")
     */
    public function caixaAction () {
        try {
            /** @var $parcelas \Orthos\Bundle\FinanceiroBundle\Business\ParcelasBusiness */
            $parcelas = $this->get('Orthos.ParcelasBusiness');

            $data = (isset($_POST['dt_vencimento']))?
                $this->getXysLibrary()->date()->convertDateTime($_POST['dt_vencimento']) : new \DateTime();

            $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas();
            $entity->setDtInicio(clone $data);
            $entity->setDtFim(clone $data);
            $entity->getDtInicio()->setTime(00,00,00);
            $entity->getDtFim()->setTime(23,59,59);

            $result = $parcelas->relatorioCaixa($entity);

            $html = $this->renderView('OrthosRelatoriosBundle:Financeiro:baixas.html.twig',
                                      array(
                                          'list' => $result,
                                          'data' => $data->format('d/m/Y')
                                      ));

            return new Response($html);

            $pdfGenerator = $this->get('spraed.pdf.generator');
            $pdfGenerator->generatePDF($html, 'UTF-8');

            $name = "baixas_" . time();

            return new Response($pdfGenerator->generatePDF($html),
                                200,
                                array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="'.$name.'.pdf"'
                                )
            );


        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/relatorio/bind/financeiro/receitas")
     */
    public function receitasAction () {
        try {
            /** @var $parcelas \Orthos\Bundle\FinanceiroBundle\Business\ParcelasBusiness */
            $parcelas = $this->get('Orthos.ParcelasBusiness');

            $mes = (isset($_POST['mes']))? $_POST['mes']:NULL;
            $ano = (isset($_POST['ano']))? $_POST['ano']:NULL;

            $result = $parcelas->relatorioReceitas($mes,$ano);

            $html = $this->renderView('OrthosRelatoriosBundle:Financeiro:receita.html.twig',
                                      array(
                                          'list' => $result,
                                          'mes' => $_POST['mes'] . '/' . $_POST['ano']
                                      ));

            return new Response($html);

            $pdfGenerator = $this->get('spraed.pdf.generator');
            $pdfGenerator->generatePDF($html, 'UTF-8');

            $name = "receitas_" . time();

            return new Response($pdfGenerator->generatePDF($html),
                                200,
                                array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="'.$name.'.pdf"'
                                )
            );
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/relatorio/bind/financeiro/inadimplencia")
     */
    public function inadimplenciaAction () {
        try {
            /** @var $paciente \Orthos\Bundle\PacienteBundle\Business\PacienteBusiness  */
            $paciente = $this->get('Orthos.PacienteBusiness');

            /** @var $status \Orthos\Bundle\ClinicaBundle\Business\PacienteStatusBusiness */
            $status = $this->get('Orthos.PacienteStatusBusiness');

            $id = $_POST['sq_paciente_status'];

            /** @var $statusPaciente \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus */
            $statusPaciente = $status->find($id);

            $result = $paciente->relatorioPacienteInadimplenteStatus(
                $statusPaciente
            );

            $html = $this->renderView('OrthosRelatoriosBundle:Financeiro:inadimplencia.html.twig',
                                      array(
                                          'list' => $result,
                                          'status' => $statusPaciente->getNoStatus()
                                      ));

            return new Response($html);

            $pdfGenerator = $this->get('spraed.pdf.generator');
            $pdfGenerator->generatePDF($html, 'UTF-8');

            $name = "inadimplencia_" . time();

            return new Response($pdfGenerator->generatePDF($html),
                                200,
                                array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="'.$name.'.pdf"'
                                )
            );
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/relatorio/bind/financeiro/parcelas")
     */
    public function parcelasAction()
    {
        /** @var $result \Orthos\Bundle\FinanceiroBundle\Business\ParcelasBusiness */
        $result = $this->get('Orthos.ParcelasBusiness');

        $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas($_POST);
        if ((!isset($_POST['dt_inicio'])) || (!isset($_POST['dt_fim']))) {
            $entity->setDtInicio(new \DateTime());
            $entity->setDtFim(new \DateTime());
        } else {
            $entity->setDtInicio(
                $this->getXysLibrary()->date()->convertDateTime($_POST['dt_inicio'])
            );

            $entity->setDtFim(
                $this->getXysLibrary()->date()->convertDateTime($_POST['dt_fim'])
            );
        }

        $entity->getDtInicio()->setTime(00,00,00);
        $entity->getDtFim()->setTime(23,59,59);

        $html = $this->renderView('OrthosRelatoriosBundle:Financeiro:parcelas.html.twig',
        array(
            'list' => $result->getParcelas($entity)
        ));

        return new Response($html);

        $pdfGenerator = $this->get('spraed.pdf.generator');
        $pdfGenerator->generatePDF($html, 'UTF-8');

        $name = "parcelas_" . time();

        return new Response($pdfGenerator->generatePDF($html),
                                                              200,
                                                              array(
                                                                  'Content-Type' => 'application/pdf',
                                                                  'Content-Disposition' => 'attachment; filename="'.$name.'.pdf"'
                                                              )
        );
    }

    public function tipoLancamentoAction () {

    }
}
