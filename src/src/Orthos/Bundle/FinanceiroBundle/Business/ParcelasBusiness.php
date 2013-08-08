<?php
namespace Orthos\Bundle\FinanceiroBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Parcelas;

class ParcelasBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\FinanceiroBundle\Model\ParcelasModel';

    public function getParcelas (Parcelas $entity) {
        $return = $this->getModel()->getParcelas($entity);
        $result = array ();

        if ($return) {
            $i=1;
            $total = 0;
            $totalParcela = 0;
            /** @var $item Parcelas */
            foreach ($return as $item) {
                $result['data'][] = array (
                    'numero' => str_pad($i,4,0,STR_PAD_LEFT),
                    'matricula' => $item->getSqFinanceiro()->getSqPaciente()->getNuMatricula(),
                    'nome' => $item->getSqFinanceiro()->getSqPaciente()->getNoPaciente(),
                    'telefone' => $item->getSqFinanceiro()->getSqPaciente()->getNuResidencial(),
                    'data_vencimento' => ($item->getDtVencimento())? $item->getDtVencimento()->format('d/m/Y') : NULL,
                    'data_pagamento' => ($item->getDtPagamento())? $item->getDtPagamento()->format('d/m/y') : NULL,
                    'valor' => number_format($item->getVlParcela(), 2),
                    'valor_pagamento' => number_format($item->getVlPagamento(), 2)
                );

                $total = $total + $item->getVlParcela();
                $totalParcela = $totalParcela + $item->getVlPagamento();
                $i++;
            }

            $result['total'] = number_format($total, 2);
            $result['totalPagamento'] = number_format($totalParcela, 2);
        }

        return $result;
    }

    public function getParcelasAtrasadasPorPaciente (Paciente $entity) {
        return $this->getModel()->getParcelasAtrasadasPorPaciente($entity);
    }

    public function getParcelasTipoPagamento (Parcelas $entity) {
        return $this->getModel()->getParcelasTipoPagamento($entity);
    }

    public function getParcelasPagasPorData (Parcelas $entity) {
        return $this->getModel()->getParcelasPagasPorData($entity);
    }

    private function _tipoPagamento ($tipo) {
        switch ($tipo) {
            case 'BO': return "Boleto"; break;
            case 'CC': return "Cartão de Crédito"; break;
            case 'CD': return "Cartão de Débito"; break;
            case 'DI': return "Dinheiro"; break;
            case 'CH': return "Cheque"; break;
        }
    }

    public function relatorioCaixa (Parcelas $entity) {
        $return = array ();
        $result = $this->getParcelasPagasPorData($entity);

        $total=0;
        $desconto=0;
        $return['data'] = array ();
        $return['total'] = 0;
        $return['desconto'] = 0;
        $return['totalGeral'] = 0;

        if ($result) {
            $i=1;
            /** @var $value Parcelas */
            foreach ($result as $value) {
                $especialidade = '';
                if ($value->getSqFinanceiro()->getSqEspecialidade()) {
                    $especialidade = $value->getSqFinanceiro()->getSqEspecialidade()->getNoEspecialidade();
                }

                $return['data'][] = array (
                    'numero' => str_pad($i, 4,0,STR_PAD_LEFT),
                    'contrato' => $value->getSqFinanceiro()->getSqPaciente()->getNuMatricula(),
                    'especialidade' => $especialidade,
                    'tipo' => $this->_tipoPagamento($value->getFlTipoPagamento()),
                    'boleta' => $value->getNuParcela(),
                    'mes' => $value->getDtVencimento()->format('m/Y'),
                    'nome' => $value->getSqFinanceiro()->getSqPaciente()->getNoPaciente(),
                    'credito' => $value->getDtPagamento()->format('d/m/Y'),
                    'documento' => $value->getTxDocumento(),
                    'valor' => number_format($value->getVlPagamento(),2,'.',','),
                    'desconto' => number_format(($value->getVlDesconto() + $value->getVlMora()),2,'.',','),
                    'total' => number_format(($value->getVlPagamento() - $value->getVlDesconto()),2,'.',','),
                    'usuario' => $value->getSqUsuarioBaixa()->getNoUsuario()
                );

                $total = $total + $value->getVlPagamento();
                $desconto = $desconto + ($value->getVlDesconto() + $value->getVlMora());

                $i++;
            }

            $return['total'] = number_format($total,2,'.',',');
            $return['desconto'] = number_format($desconto,2,'.',',');
            $return['totalGeral'] = number_format($total - $desconto,2,'.',',');
        }

        return $return;
    }

    public function relatorioReceitas ($mes, $ano) {
        $result = array ();

        if ((!$mes) || (!$ano)) {
            $this->addMessage('Selecione o mês/ano para geração do relatório');
            $this->exceptionMessages();
        }

        $diaFim = date('d', mktime(0, 0, 0, $mes, date('t') , $ano));

        $parcelas = new Parcelas();
        /** @var $business ParcelasBusiness */
        $business = $this->getModel();

        $dinheiro = 0;
        $cheque = 0;
        $debito = 0;
        $banco = 0;
        $cartao = 0;
        $a_receber = 0;

        for ($i=1;$i<=$diaFim;$i++) {
            $parcelas->setDtPagamento(new \DateTime("{$ano}-{$mes}-{$i}"));

            $parcelas->setFlTipoPagamento('DI');
            $totalDinheiro = $business->getParcelasTipoPagamento($parcelas);
            $parcelas->setFlTipoPagamento('CH');
            $totalCheque = $business->getParcelasTipoPagamento($parcelas);
            $parcelas->setFlTipoPagamento('CD');
            $totalDebito = $business->getParcelasTipoPagamento($parcelas);
            $parcelas->setFlTipoPagamento('BO');
            $totalBanco = $business->getParcelasTipoPagamento($parcelas);
            $parcelas->setFlTipoPagamento('CC');
            $totalCartao = $business->getParcelasTipoPagamento($parcelas);

            $totalDinheiro = ($totalDinheiro)? $totalDinheiro[0]['vl_pagamento'] : NULL;
            $totalCheque = ($totalCheque)? $totalCheque[0]['vl_pagamento'] : NULL;
            $totalDebito = ($totalDebito)? $totalDebito[0]['vl_pagamento'] : NULL;
            $totalCartao = ($totalCartao)? $totalCartao[0]['vl_pagamento'] : NULL;
            $totalBanco = ($totalBanco)? $totalBanco[0]['vl_pagamento'] : NULL;

            $result['data'][] = array (
                'dia' => $i,
                'dinheiro' => number_format($totalDinheiro,2,'.',','),
                'cheque' => number_format($totalCheque,2,'.',','),
                'debito' => number_format($totalDebito,2,'.',','),
                'credito' => number_format($totalCartao,2,'.',','),
                'banco' => number_format($totalBanco,2,'.',','),
                'a_receber' => number_format(0,2,'.',','),
                'total' => number_format(($totalDinheiro + $totalCheque + $totalDebito + $totalCartao + $totalBanco),2,'.',',')
            );

            $dinheiro = $dinheiro + $totalDinheiro;
            $cheque = $cheque + $totalCheque;
            $debito = $debito + $totalDebito;
            $cartao = $cartao + $totalCartao;
            $banco = $banco + $totalBanco;
            $a_receber = $a_receber + 0;
        }

        $result['total_dinheiro'] = number_format($dinheiro,2,'.',',');
        $result['total_cheque'] = number_format($cheque,2,'.',',');
        $result['total_debito'] = number_format($debito,2,'.',',');
        $result['total_credito'] = number_format($cartao,2,'.',',');
        $result['total_banco'] = number_format($banco,2,'.',',');
        $result['total_a_receber'] = number_format($a_receber,2,'.',',');
        $result['total'] = number_format(($dinheiro + $cheque + $debito + $cartao + $banco + $a_receber),2,'.',',');

        return $result;
    }

    public function save (Parcelas $entity) {
        $this->getModel()->save($entity);
    }

    public function pagamento (Parcelas $entity) {
        if (!$entity->getVlPagamento()) {
            $this->addMessage('Digite o Valor de Pagamento');
            $this->exceptionMessages();
        }

        $this->getModel()->getEntityManager()->persist($entity);
        $this->getModel()->getEntityManager()->flush();
    }
}
