<?php
namespace Core\OrthosBundle\Model;

class UsuarioModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'CoreOrthosBundle:Usuario';

    public function getUsuario (\Core\OrthosBundle\Entity\Usuario $entity) {
        $dql = "SELECT U "
            . "FROM \Core\OrthosBundle\Entity\Usuario U "
            . "WHERE U.fl_ativo = :ativo ";

        if ($entity->getNoUsuario()) {
            $dql .= "AND LOWER(U.no_usuario) LIKE :noUsuario ";
            $params['noUsuario'] = '%' . mb_strtolower($entity->getNoUsuario()) . '%';
        }

        if ($entity->getDsEmail()) {
            $dql .= "AND LOWER(U.ds_email) = :dsEmail ";
            $params['dsEmail'] = mb_strtolower($entity->getDsEmail());
        }

        $dql .= "AND U.sq_clinica = :clinica ";
        $params['clinica'] = $this->getClinica();

        $params['ativo'] = true;

        return $this->select($dql, $params);
    }

    public function getUsuarioAtendente (\Core\OrthosBundle\Entity\Usuario $entity) {
        $dql = "SELECT U "
            . "FROM \Core\OrthosBundle\Entity\Usuario U "
            . "WHERE U.fl_ativo = :ativo "
            . "AND U.fl_atendente = :atendente ";

        if ($entity->getNoUsuario()) {
            $dql .= "AND LOWER(U.no_usuario) LIKE :noUsuario ";
            $params['noUsuario'] = '%' . mb_strtolower($entity->getNoUsuario()) . '%';
        }

        $dql .= "AND U.sq_clinica = :clinica ";
        $params['clinica'] = $this->getClinica();

        $params['ativo'] = true;
        $params['atendente'] = true;

        return $this->select($dql, $params);
    }

    public function getUsuarioMedico (\Core\OrthosBundle\Entity\Usuario $entity) {
        $dql = "SELECT U "
            . "FROM \Core\OrthosBundle\Entity\Usuario U "
            . "WHERE U.fl_ativo = :ativo "
            . "AND U.fl_medico = :atendente ";

        if ($entity->getNoUsuario()) {
            $dql .= "AND LOWER(U.no_usuario) LIKE :noUsuario ";
            $params['noUsuario'] = '%' . mb_strtolower($entity->getNoUsuario()) . '%';
        }

        //$dql .= "AND U.sq_clinica = :clinica ";
        //$params['clinica'] = $this->getClinica();

        $params['ativo'] = true;
        $params['atendente'] = true;

        return $this->select($dql, $params);
    }
}
