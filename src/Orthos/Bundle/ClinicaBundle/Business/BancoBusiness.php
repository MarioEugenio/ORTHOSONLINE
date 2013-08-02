<?php
namespace Orthos\Bundle\ClinicaBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Banco;

class BancoBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ClinicaBundle\Model\BancoModel';

    public function getBancoToClinica()
    {
        return $this->getModel()->getBancoToClinica();
    }

    public function save (Banco $entity) {
        $this->_validateSave($entity);

        $entity->setFlAtivo(TRUE);

        $this->getModel()->save($entity);
    }

    private function _validateSave (Banco $entity) {
        if (!$entity->getNuBanco()) {
            $this->addMessage('O Nº do Banco é de preenchimento obrigatório');
        }

        if (!$entity->getNuAgencia()) {
            $this->addMessage('O Nº da agência é de preenchimento obrigatório');
        }

        if (!$entity->getNuConta()) {
            $this->addMessage('O Nº da conta é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }

    public function removerPorClinica (\Orthos\Bundle\ClinicaBundle\Entity\Clinica $entity) {
        $this->getModel()->removerPorClinica($entity);
    }

}
