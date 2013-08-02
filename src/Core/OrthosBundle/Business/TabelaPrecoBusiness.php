<?php
namespace Core\OrthosBundle\Business;

use Core\OrthosBundle\Entity\TabelaPreco;

class TabelaPrecoBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Core\OrthosBundle\Model\TabelaPrecoModel';

    public function search (TabelaPreco $entity=NULL) {
        return $this->getModel()->search ($entity);
    }

    public function desativar ($id) {
        $this->getModel()->desativar($id);
    }

    public function save (TabelaPreco $entity) {
        $this->_validateSave($entity);

        if (!$entity->getSqTabelaPreco()) {
            $entity->setFlAtivo(TRUE);
            $this->getModel()->save($entity);
        } else {
            $this->getModel()->update($entity);
        }
    }

    private function _validateSave (TabelaPreco $entity) {
        if (!$entity->getSqEspecialidade()) {
            $this->addMessage('O Campo Especialidade é de preenchimento obrigatório');
        }

        if (!$entity->getNoProcedimento()) {
            $this->addMessage('O Campo Nome Procedimento é de preenchimento obrigatório');
        }

        if (!$entity->getVlTotal()) {
            $this->addMessage('O Campo Valor é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}
