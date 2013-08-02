<?php
namespace Orthos\Bundle\FinanceiroBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;

class FinanceiroModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosFinanceiroBundle:Financeiro';

    public function getFinanceiroPorPaciente (Paciente $entity) {
        $params = array ();

        $dql = "SELECT P, F, E "
             . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas P "
             . "JOIN P.sq_financeiro F "
             . "LEFT JOIN F.sq_especialidade E "
             . "WHERE F.sq_paciente = :paciente "
             . "AND P.fl_status not in ('N') ";

        $params['paciente'] = $entity;

        $dql .= "ORDER BY P.dt_vencimento DESC ";

        return $this->select($dql, $params, FALSE);
    }
}
