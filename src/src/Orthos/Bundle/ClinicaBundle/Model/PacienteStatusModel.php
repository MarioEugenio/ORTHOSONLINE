<?php
namespace Orthos\Bundle\ClinicaBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Clinica;
use Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus;

class PacienteStatusModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosClinicaBundle:PacienteStatus';

    public function getAllPacienteStatus()
    {
        $dql = "SELECT S "
            . "FROM  \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus S "
            . "WHERE S.sq_status_father IS NULL ";

        return $this->select($dql, null, FALSE);
    }

    public function getPacienteStatus(PacienteStatus $pacienteStatus)
    {
        $dql = "SELECT S "
             . "FROM  \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus S "
             . "WHERE S.sq_status_father IS NULL "
             . "AND EXISTS ( SELECT S2 "
             . "FROM \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus S2 "
             . "WHERE S2.sq_status_father = S.sq_paciente_status "
             . "AND S2.sq_paciente_status = :sqStatus ) ";

        $params['sqStatus'] = $pacienteStatus->getSqStatus();

        return $this->select($dql, $params);
    }
}
