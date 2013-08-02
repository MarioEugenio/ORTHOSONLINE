<?php
namespace Orthos\Bundle\ClinicaBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Cadeira;

class CadeiraBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ClinicaBundle\Model\CadeiraModel';

    public function save (Cadeira $entity) {
        $this->_validaSave($entity);

        $entity->setFlAtivo(TRUE);

        $this->getModel()->save($entity);
    }

    private function _validaSave (Cadeira $entity) {
        if (!$entity->getNoCadeira()) {
            $this->addMessage('O Nome da Cadeira é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }

    public function removerPorClinica (\Orthos\Bundle\ClinicaBundle\Entity\Clinica $entity) {
        $this->getModel()->removerPorClinica($entity);
    }
}
