<?php
namespace Orthos\Bundle\ProntuarioBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ProntuarioBundle\Entity\Procedimento;

class ProcedimentoModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosProntuarioBundle:Procedimento';

    public function getProcedimento (Procedimento $entity) {
        $dql = "SELECT P "
             . "FROM \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento P "
             . "WHERE P.fl_ativo = :ativo ";

        $params = array ();
        $params['ativo'] = TRUE;

        if ($entity->getNoProcedimento()) {
            $dql .= "AND LOWER(P.no_procedimento) like :noProcedimento ";
            $params['noProcedimento'] = '%' .mb_strtolower($entity->getNoProcedimento()). '%';
        }

        if ($entity->getSqEspecialidade()) {
            $dql .= "AND P.sq_especialidade = :sqEspecialidade ";
            $params['sqEspecialidade'] = $entity->getSqEspecialidade();
        }
        return $this->select($dql, $params);
    }
}
