<?php
namespace Orthos\Bundle\PacienteBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus;

class PacienteModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosClinicaBundle:Paciente';

    public function getPacienteNewsllater ()
    {
        $params = array();

        $dql = "SELECT P "
            . "FROM Orthos\Bundle\ClinicaBundle\Entity\Paciente P "
            . "WHERE (P.ds_email <> '') ";

            $dql .= "AND P.sq_clinica = :clinica ";
            $params['clinica'] = $this->getClinica();


        return $this->select($dql, $params, FALSE);
    }

    public function getPacienteInadimplentePorStatus (PacienteStatus $entity) {
        $dql = "SELECT P "
             . "FROM Orthos\Bundle\ClinicaBundle\Entity\Paciente P "
             . "LEFT JOIN P.sq_paciente_status PS "
             . "WHERE ( (P.sq_paciente_status = :status) OR (PS.sq_status_father = :status) ) "
             . "AND EXISTS ( "
             . "SELECT F "
             . "FROM Orthos\Bundle\FinanceiroBundle\Entity\Parcelas PA "
             . "JOIN PA.sq_financeiro F "
             . "WHERE F.sq_paciente = P.sq_paciente "
             . "AND PA.dt_pagamento IS NULL "
             . "AND PA.dt_vencimento < :now "
             . ") ";

        $params['status'] = $entity;

        $date = new \DateTime();
        $date->setTime(0,0,0);

        $params['now'] = $date;

        return $this->select($dql, $params);
    }

    public function getPaciente (Paciente $entity) {
        $params = array();

        $dql = "SELECT P "
            . "FROM Orthos\Bundle\ClinicaBundle\Entity\Paciente P "
            . "WHERE 1 = 1 ";

        if ($entity->getNoPaciente()) {
            $dql .= "AND LOWER(P.no_paciente) LIKE :noPaciente ";
            $params['noPaciente'] = '%' . mb_strtolower($entity->getNoPaciente()). '%';
        }

        if ($entity->getNuCpf()) {
            $dql .= "AND P.nu_cpf = :nuCpf ";
            $params['nuCpf'] = $entity->getNuCpf();
        }

        if ($entity->getDsEmail()) {
            $dql .= "AND P.ds_email = :dsEmail ";
            $params['dsEmail'] = $entity->getDsEmail();
        }

        if ($entity->getNuMatricula()) {
            $dql .= "AND P.nu_matricula = :nuMatricula ";
            $params['nuMatricula'] = $entity->getNuMatricula();
        }

        $dql .= "AND P.sq_clinica = :clinica ";

        if ($entity->getSqClinica()) {
            $params['clinica'] = $entity->getSqClinica();
        } else {
            $params['clinica'] = $this->getClinica();
        }

        return $this->select($dql, $params);
    }

    public function getPacientePorNome (Paciente $entity)
    {
        $params = array();

        $dql = "SELECT P "
             . "FROM Orthos\Bundle\ClinicaBundle\Entity\Paciente P "
             . "WHERE LOWER(P.no_paciente) LIKE :noPaciente ";

        $dql .= "AND P.sq_clinica = :clinica ";

        if ($entity->getSqClinica()) {
            $params['clinica'] = $entity->getSqClinica();
        } else {
            $params['clinica'] = $this->getClinica();
        }

        $params['noPaciente'] = '%' . mb_strtolower($entity->getNoPaciente()). '%';

        return $this->select($dql, $params,TRUE, FALSE, 10, 0);
    }

    public function getMaxMatricula()
    {
        $params = array();

         $dql = "SELECT MAX(P.sq_paciente) "
             . "FROM Orthos\Bundle\ClinicaBundle\Entity\Paciente P ";

        $dql .= "WHERE P.sq_clinica = :clinica ";

        $params['clinica'] = $this->getClinica();

        $retorno = $this->select($dql, $params);

        if ($retorno) {
            $curr = current($retorno);
            return ($curr[1] + 1);
        }

        return 1;
    }
}
