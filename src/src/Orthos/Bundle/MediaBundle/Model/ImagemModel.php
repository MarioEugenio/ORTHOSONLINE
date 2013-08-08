<?php
namespace Orthos\Bundle\MediaBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\MediaBundle\Entity\Imagem;

class ImagemModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosMediaBundle:Imagem';

    public function listImagem (Imagem $entity) {
        $params = array();

        $dql = "SELECT I, U "
             . "FROM \Orthos\Bundle\MediaBundle\Entity\Imagem I "
             . "LEFT JOIN I.sq_usuario U "
             . "WHERE I.sq_paciente = :paciente ";

        if (($entity->getDtInicial()) && ($entity->getDtFinal())) {
            $dql .= "AND I.dt_cadastro BETWEEN :datIni AND :datFim ";
            $params['datIni'] = $entity->getDtInicial();
            $params['datFim'] = $entity->getDtFinal();
        }

        $params['paciente'] = $entity->getSqPaciente();

        return $this->select($dql, $params);
    }
}
