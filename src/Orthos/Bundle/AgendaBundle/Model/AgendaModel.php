<?php
namespace Orthos\Bundle\AgendaBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\AgendaBundle\Entity\Agenda;

class AgendaModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosAgendaBundle:Agenda';

    public function getAgendaPorPaciente (Paciente $entity)
    {
        $dql = "SELECT A "
             . "FROM Orthos\Bundle\AgendaBundle\Entity\Agenda A "
             . "JOIN A.sq_paciente P "
             . "WHERE A.sq_paciente = :paciente "
            . "AND A.sq_clinica = :clinica ";

        $params['paciente'] = $entity->getSqPaciente();

        if ($entity->getSqClinica()) {
            $params['clinica'] = $entity->getSqClinica();
        } else {
            $params['clinica'] = $this->getClinica();
        }

        $dql .= "ORDER BY A.dt_inicio DESC ";

        return $this->select($dql, $params);
    }

    public function getPacientePorDataObject (Agenda $entity)
    {
        $dql = "SELECT A "
            . "FROM Orthos\Bundle\AgendaBundle\Entity\Agenda A "
            . "JOIN A.sq_status S "
            . "WHERE A.dt_inicio BETWEEN :dtInicio and :dtFim "
            . "AND A.sq_status NOT IN (3) "
            . "AND A.sq_clinica = :clinica ";

        $params['dtInicio'] = $entity->getDtInicio();
        $params['dtFim'] = $entity->getDtFim();

        if ($entity->getSqClinica()) {
            $params['clinica'] = $entity->getSqClinica();
        } else {
            $params['clinica'] = $this->getClinica();
        }

        return $this->select($dql, $params);
    }

    public function getPacientePorData (Agenda $entity)
    {
        $dql = "SELECT A.sq_agenda, A.dt_inicio, A.dt_fim, A.no_paciente, A.dt_chegada, S.sq_status_consulta, S.no_status ,S.ds_cor_status "
            . "FROM Orthos\Bundle\AgendaBundle\Entity\Agenda A "
            . "JOIN A.sq_status S "
            . "WHERE A.dt_inicio BETWEEN :dtInicio and :dtFim "
            . "AND A.sq_status NOT IN (3) "
            . "AND A.sq_clinica = :clinica ";

        $params['dtInicio'] = $entity->getDtInicio();
        $params['dtFim'] = $entity->getDtFim();

        if ($entity->getSqClinica()) {
            $params['clinica'] = $entity->getSqClinica();
        } else {
            $params['clinica'] = $this->getClinica();
        }

        return $this->select($dql, $params);
    }

    public function getAgendaProntuario (Paciente $entity)
    {
        $dql = "SELECT A "
            . "FROM Orthos\Bundle\AgendaBundle\Entity\Agenda A "
            . "JOIN A.sq_status S "
            . "WHERE A.sq_status NOT IN (3, 4) "
            . "AND A.sq_paciente = :paciente ";

        $params['paciente'] = $entity;

        return $this->select($dql, $params);
    }

    public function getPacienteAgendado (Agenda $entity)
    {
        $dql = "SELECT A "
             . "FROM Orthos\Bundle\AgendaBundle\Entity\Agenda A "
             . "WHERE A.sq_cadeira = :sq_cadeira "
             . "AND A.dt_inicio = :dt_inicio "
             . "AND A.dt_fim = :dt_fim "
             . "AND A.sq_status NOT IN (3) "
             . "AND A.sq_clinica = :clinica ";

        $params['sq_cadeira'] = $entity->getSqCadeira();
        $params['dt_fim'] = $entity->getDtFim();
        $params['dt_inicio'] = $entity->getDtInicio();

        if ($entity->getSqClinica()) {
            $params['clinica'] = $entity->getSqClinica();
        } else {
            $params['clinica'] = $this->getClinica();
        }

        return $this->select($dql, $params);

    }
}
