<?php
namespace Orthos\Bundle\NewslatterBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Parcelas;
use Orthos\Bundle\NewslatterBundle\Entity\ModeloDocumento;

class ModeloDocumentoBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\NewslatterBundle\Model\ModeloDocumentoModel';

    public function save (ModeloDocumento $entity) {
        $this->_validate($entity);

        $entity->setFlAtivo(TRUE);
        $entity->setDtCadastro(new \DateTime());

        $this->getModel()->save($entity);
    }

    private function _validate (ModeloDocumento $entity) {
        if (!$entity->getNoModelo()) {
            $this->addMessage('O campo Nome é obrigatório');
        }

        if (!$entity->getTxHeader()) {
            $this->addMessage('O campo Cabeçalho é obrigatório');
        }

        if (!$entity->getTxBody()) {
            $this->addMessage('O campo Corpo é obrigatório');
        }

        if (!$entity->getTxFooter()) {
            $this->addMessage('O campo Rodapé é obrigatório');
        }

        $this->exceptionMessages();
    }
}
