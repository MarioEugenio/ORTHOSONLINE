<?php
namespace Orthos\Bundle\FinanceiroBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Financeiro;

class FinanceiroBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\FinanceiroBundle\Model\FinanceiroModel';

    public function getFinanceiroPorPaciente (Paciente $entity) {
        return $this->getModel()->getFinanceiroPorPaciente($entity);
    }

    public function baixarRemessa ($file) {
        $arr = array ();

        if (file_exists($file)) {
            $file = @fopen( $file, "r" );
            $i=0;
            while(!feof($file)){

                $linha = fgets(  $file, 4096 );

                if($i != 0 ){
                    $arr[$i]['ID'] =  ltrim(substr($linha,63,7),0);
                    $arr[$i]['VALPAG'] =  $this->_formatarValor(ltrim(substr($linha,152,13),0));
                    $arr[$i]['VALCOB'] =  $this->_formatarValor(ltrim(substr($linha,253,13),0));
                    $arr[$i]['DAT'] =  $this->_formatarDataRemessa(substr($linha,295,6));
                }

                $i++;
            }
        }

        return $this->checkCobranca($arr);
    }

    private function checkCobranca ($arrCob) {
        $retorno = array ();
        if ($arrCob) {
            /** @var $business ParcelasBusiness */
            $business = $this->callService('Orthos.ParcelasBusiness');
            foreach ($arrCob as $value) {
                /** @var $result \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
                $result = $business->findBy(TRUE, array (
                    'nu_parcela' => $value['ID']
                ));

                if ($result) {
                    $result = $result[0];

                    $retorno[] = array (
                        'nu_parcela' => $result->getNuParcela(),
                        'sq_parcela' => $result->getSqParcelas(),
                        'no_paciente' => ($result->getSqFinanceiro())? $result->getSqFinanceiro()->getSqPaciente()->getNoPaciente(): null,
                        'vl_pagamento' => $value['VALPAG'],
                        'vl_parcela' => $value['VALCOB'],
                        'dt_pagamento' => $value['DAT'],
                        'check' => true,
                        'pago' => ($result->getDtPagamento())? true : false
                    );

                } else {
                    $retorno[] = array (
                        'nu_parcela' => $value['ID'],
                        'sq_parcela' => null,
                        'no_paciente' => null,
                        'vl_pagamento' => $value['VALPAG'],
                        'vl_parcela' => $value['VALCOB'],
                        'dt_pagamento' => $value['DAT'],
                        'check' => false,
                        'pago' => false
                    );
                }

            }
        }

        return $retorno;
    }

    private function _formatarValor ($valor) {
        $lenght = strlen($valor) - 2;
        $valor = substr($valor,0,$lenght) . '.' . substr($valor, -2);
        return number_format((float)$valor, 2, '.', '');
    }

    private function _formatarDataRemessa ($data) {
        if (!$data) return '';

        return substr($data,0,2) . '/' . substr($data,2,2) . '/20'.substr($data,-2);
    }

    public function saveNegociacao (Financeiro $entity, $dtInicial, $desconto, Array $parcelas=null) {
        $nuParcelas = $entity->getNuParcelas();
        $arrParcelas = array();


        for ($i=1;$i<=$nuParcelas;$i++) {

            $date = $this->getXysLibrary()->date()->convertDateTime($dtInicial);
            $date->add(new \DateInterval("P{$i}M"));

            $arrParcelas[] = array (
                'parcela' => $i,
                'valor' => (($entity->getVlTotal() / $nuParcelas) - $desconto),
                'data' => $date
            );
        }

        $parcelaNegociacao = $this->save($entity, $arrParcelas);

        if ($parcelas) {
            foreach ($parcelas as $value) {
                /** @var $parcela \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
                $parcela = $this->callService('Orthos.ParcelasBusiness')->find($value['sqParcelas']);
                $parcela->setSqParcelaNegociada($parcelaNegociacao);
                $parcela->setFlStatus('N');
                $parcela->setSqUsuarioBaixa($this->getAuthenticate());

                $this->getModel()->getEntityManager()->persist($parcela);
                $this->getModel()->getEntityManager()->flush();
            }
        }
    }

    public function save (Financeiro $entity, Array $parcelas = null) {
        $this->beginTransaction();
        try {
            $this->getModel()->save($entity);

            $parcela = $this->_addParcelas($entity, $parcelas);

            $this->commit();

            return $parcela;
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            $this->rollback();
        }
    }

    private function _addParcelas (Financeiro $financeiro, $arrParcelas=NULL) {
        $business = $this->callService('Orthos.ParcelasBusiness');

        if ($arrParcelas) {

            $dateAnterior = NULL;
            foreach($arrParcelas as $value) {
                $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas();

                $data = ($value['data'] instanceof \DateTime)? $value['data'] : $this->getXysLibrary()->date()->convertDateTime($value['data']);

                $entity->setDtVencimento($data);
                $entity->setFlStatus('G');
                $entity->setNuParcela($value['parcela']);
                $entity->setVlParcela($value['valor']);
                $entity->setSqFinanceiro($financeiro);
                $entity->setFlTipoPagamento(
                    $financeiro->getFlTipoPagamento()
                );

                $business->save($entity);
            }

            return $entity;
        }
    }
}
