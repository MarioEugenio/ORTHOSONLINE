<?php
namespace Orthos\Bundle\ProntuarioBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ProntuarioBundle\Entity\Prontuario;

class ProntuarioModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosProntuarioBundle:Prontuario';

    public function listProntuario (Prontuario $entity) {

        $params = array ();
        $dql = "SELECT P, U "
             . "FROM Orthos\Bundle\ProntuarioBundle\Entity\Prontuario P "
             . "JOIN P.sq_usuario U "
             . "WHERE P.sq_paciente = :paciente ";
        $params['paciente'] = $entity->getSqPaciente();

        if (($entity->getDtInicial()) && ($entity->getDtFinal())) {
            $dql .= "AND P.dt_procedimento BETWEEN :datIni AND :datFim ";
            $params['datIni'] = $entity->getDtInicial();
            $params['datFim'] = $entity->getDtFinal();
        }

        $dql .= "ORDER BY P.dt_procedimento DESC ";
        return $this->select($dql, $params);
    }

    public function listMaxProntuario (Prontuario $entity) {

        $params = array ();
        $dql = "SELECT P, U "
            . "FROM Orthos\Bundle\ProntuarioBundle\Entity\Prontuario P "
            . "JOIN P.sq_usuario U "
            . "WHERE P.sq_paciente = :paciente ";

            $dql .= "AND P.dt_procedimento = (
                SELECT MAX(PR.dt_procedimento)
                FROM Orthos\Bundle\ProntuarioBundle\Entity\Prontuario PR
                WHERE PR.sq_paciente = :paciente
            ) ";

        $dql .= "ORDER BY P.dt_procedimento DESC";

        $params['paciente'] = $entity->getSqPaciente();

        return $this->select($dql, $params);
    }
}
