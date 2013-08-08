<?php
namespace Orthos\Bundle\ClinicaBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Banco;

class BancoModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosClinicaBundle:Banco';

    public function getBancoToClinica ()
    {
        $dql = "SELECT B FROM Orthos\Bundle\ClinicaBundle\Entity\Banco B "
            . "WHERE B.fl_ativo = :ativo "
            . "AND B.sq_clinica = :clinica ";

        $params['clinica'] = $this->getClinica();
        $params['ativo'] = TRUE;

        return $this->select($dql, $params, FALSE);
    }

    public function removerPorClinica (\Orthos\Bundle\ClinicaBundle\Entity\Clinica $entity) {
        $params = array();

        $dql = "UPDATE Orthos\Bundle\ClinicaBundle\Entity\Banco B SET "
             . "B.fl_ativo = :ativo "
             . "WHERE B.sq_clinica = :clinica ";

        $params['clinica'] = $entity->getSqClinica();
        $params['ativo'] = FALSE;

        $this->execute($dql, $params);
    }
}
