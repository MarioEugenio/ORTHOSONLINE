<?php
namespace Core\OrthosBundle\Model;

use Core\OrthosBundle\Entity\TabelaPreco;

class TabelaPrecoModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'CoreOrthosBundle:TabelaPreco';

    public function search (TabelaPreco $entity=NULL) {
        $params = array ();
        $dql = "SELECT T, E "
             . "FROM \Core\OrthosBundle\Entity\TabelaPreco T "
             . "JOIN T.sq_especialidade E "
             . "WHERE T.fl_ativo = :ativo ";
        $params['ativo'] = TRUE;

        if ($entity->getNoProcedimento()) {
            $dql .= "AND LOWER(T.no_procedimento) LIKE :nome ";
            $params['nome'] = '%' . mb_strtolower($entity->getNoProcedimento()) . '%';
        }

        return $this->select($dql, $params, FALSE);
    }

    public function desativar ($id) {
        $dql = "UPDATE \Core\OrthosBundle\Entity\TabelaPreco  SET fl_ativo = :ativo "
             . "WHERE sq_tabela_preco = :id ";
        $param['ativo'] = FALSE;
        $param['id'] = $id;

        $this->execute($dql,$param);
    }
}
