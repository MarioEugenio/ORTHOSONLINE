<?php
namespace Orthos\Bundle\FinanceiroBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Financeiro;
use Orthos\Bundle\FinanceiroBundle\Entity\Lancamentos;

class LancamentosBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\FinanceiroBundle\Model\LancamentosModel';

    public function getLancamentos (Lancamentos $entity) {
        return $this->getModel()->getLancamentos($entity);
    }

    public function save (Lancamentos $entity, $nuRepeticao=NULL, $tipRepeticao=NULL) {
        try {
            $this->_validateSave($entity);

            $entity->setDtCadastro(new \DateTime());

            $entity->setVlDesconto(
                $this->prepareMoney($entity->getVlDesconto())
            );

            $entity->setVlNominal(
                $this->prepareMoney($entity->getVlNominal())
            );

            if (!$nuRepeticao) $nuRepeticao = 1;

            for ($i=0;$i<$nuRepeticao;$i++) {
                $clone = clone $entity;

                $this->getModel()->getEntityManager()->persist($clone);
                $this->getModel()->getEntityManager()->flush();

                $this->_defineDate($clone, $tipRepeticao);
            }

        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {

            throw $exc;
        }
    }

    private function _defineDate (Lancamentos $entity, $tipRepeticao=NULL) {
        if ($tipRepeticao !== NULL) {
            if ($tipRepeticao) {
                $entity->getDtVencimento()->add(new \DateInterval('P1M'));
            } else {
                $entity->getDtVencimento()->add(new \DateInterval('P7D'));
            }
        }
    }

    private function _validateSave (Lancamentos $entity) {


        if (!$entity->getSqLancamentosCategoria()) {
            $this->addMessage('O Campo Categoria é de preenchimento obrigatório');
        }

        if (!$entity->getFlTipoDocumento()) {
            $this->addMessage('O Campo Tipo de Documento é de preenchimento obrigatório');
        }

        if (!$entity->getDtEmissao()) {
            $this->addMessage('O Campo Data é de preenchimento obrigatório');
        }

        if (!$entity->getDtVencimento()) {
            $this->addMessage('O Campo Data do Lançamento é de preenchimento obrigatório');
        }

        if (!$entity->getVlNominal()) {
            $this->addMessage('O Campo Valor é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}
