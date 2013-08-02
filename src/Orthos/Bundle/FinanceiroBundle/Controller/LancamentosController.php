<?php

namespace Orthos\Bundle\FinanceiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Orthos\Bundle\FinanceiroBundle\Entity\Lancamentos;

class LancamentosController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\FinanceiroBundle\Business\LancamentosBusiness';

    /**
     * @Route("/orthos/financeiro/lancamentos/list")
     */
    public function listAction () {
        $form = $this->getRequestJson();
        $entity = new Lancamentos($form);

        if (isset ($form['banco'])) {
            $entity->setSqBanco(
                $this->get('Orthos.BancoBusiness')->find($form['banco'])
            );
        }

        if (isset($form['sq_fornecedor'])) {
            $entity->setSqFornecedor(
                $this->get('Orthos.FornecedorBusiness')->find($form['sq_fornecedor'])
            );
        }

        if (isset($form['sq_lancamentos_categoria'])) {
            $entity->setSqLancamentosCategoria(
                $this->get('Orthos.LancamentosCategoriaBusiness')->find($form['sq_lancamentos_categoria'])
            );
        }

        if ((!isset($form['dt_inicio'])) || (!isset($form['dt_fim']))) {
            $entity->setDtInicio(new \DateTime());
            $entity->setDtFim(new \DateTime());
        } else {
            $entity->setDtInicio(
                $this->getXysLibrary()->date()->convertDateTime($form['dt_inicio'])
            );

            $entity->setDtFim(
                $this->getXysLibrary()->date()->convertDateTime($form['dt_fim'])
            );
        }

        $entity->getDtInicio()->setTime(00,00,00);
        $entity->getDtFim()->setTime(23,59,59);

        $result = $this->getBusiness()->getLancamentos($entity);

        $return = array ();

        $saldo = 0;
        $credito = 0;
        $debito = 0;
        /** @var $value Lancamentos */
        foreach ($result as $value) {
            $saldo = $this->_calcularSaldo($saldo, $value);
            if ($value->getFlTipoMovimento() == 'C') $credito = $credito +  $value->getVlNominal();
            if ($value->getFlTipoMovimento() == 'D') $debito = $debito +  $value->getVlNominal();

            $return['list'][] = array (
                'sq_lancamentos' => $value->getSqLancamentos(),
                'fornecedor' => ($value->getSqFornecedor())? $value->getSqFornecedor()->getNoFornecedor() : NULL,
                'categoria' => ($value->getSqLancamentosCategoria())? $value->getSqLancamentosCategoria()->getNoCategoria(): NULL,
                'nu_documento' => $value->getNuDocumento(),
                'fl_tipo_documento' => $value->getFlTipoDocumento(),
                'fl_tipo_movimento' => $value->getFlTipoMovimento(),
                'vl_nominal' => number_format($value->getVlNominal(),2,',','.'),
                'dt_vencimento' => $value->getDtVencimento()->format('d/m/Y'),
                'tx_observacao' => $value->getTxObservacao(),
                'saldo' => number_format($saldo,2,',','.')
            );
        }

        $return['totalSaldo'] = number_format($saldo,2,',','.');
        $return['totalCredito'] = number_format($credito,2,',','.');
        $return['totalDebito'] = number_format($debito,2,',','.');

        return $this->responseJson($return);
    }

    private function _calcularSaldo ($saldo, Lancamentos $entity) {
        if ($entity->getFlTipoMovimento() == 'D') {
            $saldo = $saldo - $entity->getVlNominal();
        }

        if ($entity->getFlTipoMovimento() == 'C') {
            $saldo = $saldo + $entity->getVlNominal();
        }

        return $saldo;
    }

    /**
     * @Route("/orthos/financeiro/lancamentos")
     * @Template()
     */
    public function indexAction()
    {
        $clinica = $this->getClinica();
        $banco = $this->get('Orthos.BancoBusiness');

        $result = $banco->getBancoToClinica();

        $categoria = $this->get('Orthos.LancamentosCategoriaBusiness')->findAll(FALSE);
        $fornecedor = $this->get('Orthos.FornecedorBusiness')->findAll(FALSE);

        return array(
            'listConta' => json_encode($result),
            'listCategoria' => json_encode($categoria),
            'listFornecedor' => json_encode($fornecedor)
        );
    }

    /**
     * @Route("/orthos/financeiro/lancamentos/save")
     */
    public function saveAction () {
        try {
            $form = $this->getRequestJson();
            $isEdit = FALSE;

            if (isset($form['sq_lancamentos'])) {
                $isEdit = TRUE;
            }

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sq_lancamentos']);
                $entity->setObject($form);
            } else {
                $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Lancamentos($form);
            }

            if (isset($form['sq_banco'])) {
                /** @var $banco \Orthos\Bundle\ClinicaBundle\Business\BancoBusiness */
                $banco = $this->get('Orthos.BancoBusiness');
                $result = $banco->find($form['sq_banco']);

                if ($result) $entity->setSqBanco($result);
            }

            if (isset($form['sq_fornecedor'])) {
                $entity->setSqFornecedor(
                    $this->get('Orthos.FornecedorBusiness')->find($form['sq_fornecedor'])
                );
            }

            if (isset($form['sq_lancamentos_categoria'])) {
                $entity->setSqLancamentosCategoria(
                    $this->get('Orthos.LancamentosCategoriaBusiness')->find($form['sq_lancamentos_categoria'])
                );
            }

            if (isset($form['dt_emissao'])) {
                $entity->setDtEmissao(
                    $this->getXysLibrary()->date()->convertDateTime($form['dt_emissao'])
                );
            }

            if (isset($form['dt_vencimento'])) {
                $entity->setDtVencimento(
                    $this->getXysLibrary()->date()->convertDateTime($form['dt_vencimento'])
                );
            }

            $nuRepeticao = (isset($form['repeticao']))? (int) $form['repeticao']['nu_repeticao'] : NULL;

            $tipoRepeticao = NULL;
            if (isset($form['repeticao'])){
                if (isset($form['repeticao']['mensal'])) {
                    $tipoRepeticao = $form['repeticao']['mensal'];
                }
            }

            $this->getBusiness()->save($entity, $nuRepeticao, $tipoRepeticao);

            if ($isEdit) {
                return $this->responseMessage('Alteração realizada com sucesso', TRUE);
            }

            return $this->responseMessage('Cadastro realizado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }
}
