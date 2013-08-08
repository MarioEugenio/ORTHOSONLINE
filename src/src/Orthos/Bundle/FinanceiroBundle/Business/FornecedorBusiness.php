<?php
namespace Orthos\Bundle\FinanceiroBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Financeiro;
use Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor;

class FornecedorBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\FinanceiroBundle\Model\FornecedorModel';

    public function save (Fornecedor $entity) {
        $this->_validateSave($entity);

        if (!$entity->getSqFornecedor()) {
            $entity->setFlAtivo(TRUE);
            $this->getModel()->save($entity);
        } else {
            $this->getModel()->update($entity);
        }
    }

    public function getAutocomplete (Fornecedor $entity) {
        $model = $this->getModel();

        $result = $model->getFornecedor($entity);
        $return = array();

        if ($result) {
            foreach ($result as $value) {
                $return[] = array(
                    'id' => $value->getSqFornecedor() ,
                    'value' => $value->getNoFornecedor()
                );
            }
        }

        return $return;
    }

    public function getFornecedor (Fornecedor $entity) {
        return $this->getModel()
                    ->getFornecedor($entity);
    }

    private function _validateSave (Fornecedor $entity) {
        if (!$entity->getNoFornecedor()) {
            $this->addMessage('O Campo Nome Fornecedor é de preenchimento obrigatório');
        }

        if (!$entity->getNoRazaoSocial()) {
            $this->addMessage('O Campo Razão Social é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}
