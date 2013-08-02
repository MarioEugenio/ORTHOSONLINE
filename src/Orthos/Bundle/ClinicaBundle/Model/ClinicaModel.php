<?php
namespace Orthos\Bundle\ClinicaBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Clinica;

class ClinicaModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosClinicaBundle:Clinica';

    public function search (Clinica $entity) {
        $params = array();
        $dql = "SELECT C "
             . "FROM \Orthos\Bundle\ClinicaBundle\Entity\Clinica C "
             . "WHERE C.fl_ativo = :ativo ";
        $params['ativo'] = TRUE;

        if ($entity->getNoClinica()) {
            $dql .= "AND LOWER(C.no_clinica) LIKE :noClinica ";
            $params['noClinica'] = '%'. mb_strtolower($entity->getNoClinica()) .'%';
        }

        return $this->select($dql, $params);
    }
}
