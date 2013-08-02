<?php
namespace Orthos\Bundle\FinanceiroBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Parcelas;

class ParcelasModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosFinanceiroBundle:Parcelas';

    public function getParcelas (Parcelas $entity) {
        $dql = "SELECT P "
             . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas P "
             . "JOIN P.sq_financeiro F "
             . "JOIN F.sq_paciente PA "
             . "WHERE P.sq_parcelas > 0 "
             . "AND P.dt_vencimento BETWEEN :dtInicio AND :dtFim ";

        $params['dtInicio'] = $entity->getDtInicio();
        $params['dtFim'] = $entity->getDtFim();

        if ($entity->getIsAtraso() == 'false') {
            $dql .= "AND P.vl_pagamento IS NULL ";
        }

        $dql .= "AND PA.sq_clinica = :clinica ";
        $params['clinica'] = $this->getClinica();

        $dql .= "ORDER BY P.dt_vencimento DESC ";

        return $this->select($dql, $params);
    }

    public function getParcelasAtrasadasPorPaciente (Paciente $entity) {
        $dql = "SELECT P "
            . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas P "
            . "JOIN P.sq_financeiro F "
            . "JOIN F.sq_paciente PA "
            . "WHERE F.sq_paciente = :paciente "
            . "AND P.dt_pagamento IS NULL "
            . "AND P.dt_vencimento < :now ";

        $date = new \DateTime();
        $date->setTime(0,0,0);

        $params['paciente'] = $entity;
        $params['now'] = $date;


        return $this->select($dql, $params);
    }

    public function getParcelasTipoPagamento (Parcelas $entity) {
        $dql = "SELECT SUM(P.vl_pagamento) as vl_pagamento "
             . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas P "
            . "JOIN P.sq_financeiro F "
            . "JOIN F.sq_paciente PA "
             . "WHERE P.fl_tipo_pagamento = :tipo "
             . "AND P.dt_pagamento = :date ";

        $params['tipo'] = $entity->getFlTipoPagamento();
        $params['date'] = $entity->getDtPagamento();

        $dql .= "AND PA.sq_clinica = :clinica ";
        $params['clinica'] = $this->getClinica();

        $dql .= "ORDER BY P.dt_vencimento DESC ";

        return $this->select($dql, $params);
    }

    public function getParcelasPagasPorData (Parcelas $entity) {
        $dql = "SELECT P "
            . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas P "
            . "JOIN P.sq_financeiro F "
            . "JOIN F.sq_paciente PA "
            . "WHERE P.dt_pagamento IS NOT NULL "
            . "AND P.dt_pagamento BETWEEN :dtInicio AND :dtFim ";

        $params['dtInicio'] = $entity->getDtInicio();
        $params['dtFim'] = $entity->getDtFim();

        $dql .= "AND PA.sq_clinica = :clinica ";
        $params['clinica'] = $this->getClinica();

        $dql .= "ORDER BY P.dt_vencimento DESC ";

        return $this->select($dql, $params);
    }
}
