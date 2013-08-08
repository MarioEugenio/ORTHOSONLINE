<?php
namespace Orthos\Bundle\ClinicaBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus;

class PacienteStatusBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ClinicaBundle\Model\PacienteStatusModel';

    public function getAllPacienteStatus() {
        return $this->getModel()->getAllPacienteStatus();
    }

    public function getPacienteStatus(PacienteStatus $pacienteStatus) {
        return $this->getModel()->getPacienteStatus($pacienteStatus);
    }
}
