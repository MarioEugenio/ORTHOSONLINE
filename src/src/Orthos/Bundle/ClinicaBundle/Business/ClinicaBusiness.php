<?php
namespace Orthos\Bundle\ClinicaBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Clinica;

class ClinicaBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ClinicaBundle\Model\ClinicaModel';

    public function search (Clinica $entity) {
        return $this->getModel()->search($entity);
    }

    public function save (Clinica $entity, Array $arrBancos=NULL, Array $arrCadeiras=NULL) {
        $this->beginTransaction();

        try {
            $this->_validaSave($entity);

            if (!$entity->getSqClinica()) {
                $this->getModel()->save($entity);
            } else {
                $this->getModel()->update($entity);
            }


            $this->_cadastrarBancos($entity, $arrBancos);
            $this->_cadastrarCadeiras($entity, $arrCadeiras);

            $this->commit();
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            $this->rollback();

            throw $exc;
        }
    }

    private function _cadastrarCadeiras (Clinica $clinica, Array $arrCadeiras=NULL) {
        if ($arrCadeiras) {
            $business = $this->callService('Orthos.CadeiraBusiness');
            $business->removerPorClinica($clinica);

            foreach ($arrCadeiras as $value) {
                $entity = new \Orthos\Bundle\ClinicaBundle\Entity\Cadeira($value);
                $entity->setSqClinica($clinica);

                $business->save($entity);
            }
        }
    }

    private function _cadastrarBancos (Clinica $clinica, Array $arrBancos=NULL) {
        if ($arrBancos) {
            $business = $this->callService('Orthos.BancoBusiness');

            $business->removerPorClinica($clinica);

            foreach ($arrBancos as $value) {
                $entity = new \Orthos\Bundle\ClinicaBundle\Entity\Banco($value);
                $entity->setSqClinica($clinica);

                if ($entity->getNuBanco() == $clinica->getFlDefault()) {
                    $entity->setStDefault(TRUE);
                }

                $business->save($entity);
            }
        }
    }

    private function _validaSave (Clinica $entity) {
        if (!$entity->getNoClinica()) {
            $this->addMessage('O Nome da Clínica é de preenchimento obrigatório');
        }

        if (!$entity->getDsEmailClinica()) {
            $this->addMessage('O E-mail é de preenchimento obrigatório');
        }

        if (!$entity->getNoRazaoSocial()) {
            $this->addMessage('O Razão Social é de preenchimento obrigatório');
        }

        if (!$entity->getNuCnpj()) {
            $this->addMessage('O CNPJ é de preenchimento obrigatório');
        }

        if (!$entity->getNuIntervalo()) {
            $this->addMessage('O Intervalo para Consultas é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}
