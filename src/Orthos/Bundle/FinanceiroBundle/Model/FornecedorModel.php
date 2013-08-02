<?php
namespace Orthos\Bundle\FinanceiroBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor;

class FornecedorModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosFinanceiroBundle:Fornecedor';

    public function getFornecedor (Fornecedor $entity) {
        $dql = "SELECT F "
             . "FROM \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor F "
             . "WHERE F.fl_ativo = :ativo ";

        if ($entity->getNoFornecedor()) {
            $dql .= "AND LOWER(F.no_fornecedor) LIKE :noFornecedor ";
            $params['noFornecedor'] = '%'.strtolower($entity->getNoFornecedor()).'%';
        }

        $params['ativo'] = TRUE;

        return $this->select($dql, $params);
    }
}
