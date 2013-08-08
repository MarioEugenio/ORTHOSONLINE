<?php

namespace Orthos\Bundle\FinanceiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Core\OrthosBundle\Entity\TabelaPreco;

class FinanceiroController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\FinanceiroBundle\Business\FinanceiroBusiness';

    /**
     * @Route("/orthos/financeiro/orcamento")
     * @Template()
     */
    public function orcamentoAction()
    {
        $tabelaPreco = $this->get('Core.TabelaPrecoBusiness')->search(new TabelaPreco());

        return array(
            'tabelaPreco' => json_encode($tabelaPreco)
        );
    }

    /**
     * @Route("/orthos/financeiro/listParcelasAtrasadaPaciente/{id}")
     */
    public function listParcelasAtrasadaPacienteAction ($id) {

        $result = $this->get('Orthos.ParcelasBusiness')->getParcelasAtrasadasPorPaciente(
            $this->get('Orthos.PacienteBusiness')->find($id)
        );

        return $this->responseJson(
            $this->convertToArray($result)
        );
    }

    /**
     * @Route("/orthos/financeiro/remessa")
     * @Template()
     */
    public function remessaAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/financeiro/retorno")
     */
    public function retornoAction () {
        try {
            $request = $this->getRequest();
            $destination = preg_replace('/app$/si', 'web' . $request->request->get('folder'), $this->get('kernel')->getRootDir());
            $destination = $destination.'/uploads/tmp/remessa/';

            $targetFolder = $destination; // Relative to the root

            if (!empty($_FILES) ) {
                $tempFile = $_FILES['Filedata']['tmp_name'];

                $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
                $targetFile =  $_FILES['Filedata']['name'];
                // Validate the file type
                $fileTypes = array('ret', 'RET', 'txt', 'TXT'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);

                if (in_array($fileParts['extension'],$fileTypes)) {

                    $file = $destination . 'RM'.time().$targetFile;

                    move_uploaded_file($tempFile,$file);

                    $retorno = $this->getBusiness()->baixarRemessa($file);

                    return $this->responseJson(
                        array(
                            "success" => true,
                            "title" => 'AVISO',
                            "message" => 'Executado com sucesso',
                            "result" => $retorno
                        ));
                } else {
                    return $this->responseJson(
                        array(
                            "success" => false,
                            "title" => 'AVISO',
                            "message" => 'Formato de arquivo inválido',
                            "result" => 'NULL'
                        ));
                }
            }

        } catch (\Exception $exc) {
            return $this->responseJson(
                $this->response($exc->getMessage(), false));
        }

        return $this->responseJson(
            array(
                "success" => false,
                "title" => 'AVISO',
                "message" => 'Ocorreu um erro ao executar o processo',
                "result" => 'NULL'
            ));
    }

    /**
     * @Route("/orthos/financeiro/pagarParcela")
     */
    public function pagarParcelaAction () {
        try {
            $form = $this->getRequestJson();

            /** @var $entity \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
            $entity = $this->get('Orthos.ParcelasBusiness')->find($form['parcela']);
            $entity->setObject($form);
            $entity->setSqUsuarioBaixa($this->getAuthenticate());
            $entity->setDtPagamento(new \DateTime());
            if (isset($form['pagamento'])) {
                $entity->setFlTipoPagamento(
                    $this->_setPagamento($form['pagamento'])
                );
            }

            $this->get('Orthos.ParcelasBusiness')->pagamento($entity);

            return $this->responseMessage('Pagamento efetivado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/financeiro/chequeDevolvido")
     */
    public function chequeDevolvidoAction () {
        try {
            $form = $this->getRequestJson();

            /** @var $entity \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
            $entity = $this->get('Orthos.ParcelasBusiness')->find($form['parcela']);
            $entity->setFlChequeDevolvido(TRUE);

            $this->get('Orthos.ParcelasBusiness')->getModel()->getEntityManager()->persist($entity);
            $this->get('Orthos.ParcelasBusiness')->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Pagamento efetivado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }


    /**
     * @Route("/orthos/financeiro/efetivarNegociacao")
     */
    public function efetivarNegociacaoAction () {
        try {
            $form = $this->getRequestJson();

            $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Financeiro($form);
            $entity->setDtCadastro(new \DateTime());
            $entity->setSqPaciente(
                $this->get('Orthos.PacienteBusiness')->find($form['sq_paciente'])
            );
            $entity->setSqUsuario($this->getAuthenticate());
            $entity->setFlTipoPagamento(
                $this->_setPagamento($form['pagamento'])
            );

            $desconto = (isset($form['vl_desconto']))? $form['vl_desconto'] : 0;
            $vencimento = ($form['dt_vencimento'])? $form['dt_vencimento'] : date('d/m/Y');

            $business = $this->getBusiness();
            $business->saveNegociacao($entity, $vencimento, $desconto, $form['parcelas']);

            return $this->responseMessage('Negociação efetivada com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    private function _setPagamento ($data) {
        if ($data['boleto'])  return 'BO';

        if ($data['cartao_credito'])  return 'CC';

        if ($data['cartao_debito']) return 'CD';

        if ($data['dinheiro']) return 'DI';

        if ($data['cheque']) return 'CH';
    }

    /**
     * @Route("/orthos/financeiro/gerarParcelas")
     */
    public function gerarParcelasAction () {
        try {
            $form = $this->getRequestJson();

            $financeiro = $form['cobranca'];
            $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Financeiro($financeiro);
            $entity->setFlTipoPagamento(
                $this->_setPagamento($form['pagamento'])
            );
            $entity->setDtCadastro(new \DateTime());
            $entity->setVlTotal($financeiro['nu_valor_total']);
            $entity->setSqPaciente($this->get('Orthos.PacienteBusiness')->find($form['paciente']));
            $entity->setSqUsuario($this->getAuthenticate());

            if (isset($form['especialidade'])) {
                $entity->setSqEspecialidade(
                    $this->get('Core.EspecialidadeBusiness')->find($form['especialidade'])
                );
            }

            $this->getBusiness()->save($entity, $form['parcelas']);

            return $this->responseMessage('Parcela(s) geradas com sucesso', TRUE);

        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/financeiro/list/{id}")
     */
    public function listAction($id)
    {
        $post = $this->getRequestJson();

        $paciente = $this->get('Orthos.PacienteBusiness')->find($id);

        $business = $this->getBusiness();
        $return = $business->getFinanceiroPorPaciente($paciente);


        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/financeiro/boleto/{id}")
     */
    public function boletoAction ($id) {
        /** @var $parcela \Orthos\Bundle\FinanceiroBundle\Business\ParcelasBusiness */
        $parcela = $this->get('Orthos.ParcelasBusiness');
        /** @var $obj \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
        $obj = $parcela->find($id);

        /** @var $banco \Orthos\Bundle\ClinicaBundle\Business\BancoBusiness */
        $banco = $this->get('Orthos.BancoBusiness');

        $result = $obj->toArray();
        $result2 = $obj->getSqFinanceiro()->getSqPaciente()->toArray();
        $result3 = $this->getClinica()->toArray();

        $url = http_build_query($result + $result2 + $result3);

        return $this->redirect('/boletophp/boleto_itau.php?' . $url);
    }
}
