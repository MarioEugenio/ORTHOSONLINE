<?php
namespace Orthos\Bundle\FinanceiroBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Lancamentos;

class LancamentosModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosFinanceiroBundle:Lancamentos';

    public function getLancamentos (Lancamentos $entity) {
        $dql = "SELECT L "
             . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Lancamentos L "
             . "WHERE L.dt_vencimento BETWEEN :dtIni AND :dtFim ";

        $params['dtIni'] = $entity->getDtInicio();
        $params['dtFim'] = $entity->getDtFim();

        if ($entity->getSqBanco()) {
            $dql .= "AND L.sq_banco = :conta ";
            $params['conta'] = $entity->getSqBanco();
        }

        if ($entity->getSqFornecedor()) {
            $dql .= "AND L.sq_fornecedor = :fornecedor ";
            $params['fornecedor'] = $entity->getSqFornecedor();
        }

        if ($entity->getSqLancamentosCategoria()) {
            $dql .= "AND L.sq_lancamentos_categoria = :categoria ";
            $params['categoria'] = $entity->getSqLancamentosCategoria();
        }

        if ($entity->getFlTipoDocumento()) {
            $dql .= "AND L.fl_tipo_documento = :documento ";
            $params['documento'] = $entity->getFlTipoDocumento();
        }

        return $this->select($dql, $params);
    }
}
