<?php
namespace Orthos\Bundle\ClinicaBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\Cadeira;

class CadeiraModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosClinicaBundle:Cadeira';

    public function removerPorClinica (\Orthos\Bundle\ClinicaBundle\Entity\Clinica $entity) {
        $params = array();

        $dql = "UPDATE Orthos\Bundle\ClinicaBundle\Entity\Cadeira C SET "
            . "C.fl_ativo = :ativo "
            . "WHERE C.sq_clinica = :clinica ";

        $params['clinica'] = $entity->getSqClinica();
        $params['ativo'] = FALSE;

        $this->execute($dql, $params);
    }
}
