<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Atendente
 *
 * @ORM\Table(name="tb_atendente")
 * @ORM\Entity
 */
class Atendente extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_atendente", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_atendente;

    /**
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_usuario", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_usuario;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Clinica")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_clinica", referencedColumnName="sq_clinica")
     * })
     */
    private $sq_clinica;

    /**
     * @var boolean
     *
     * @ORM\Column(name="st_ativo", type="boolean")
     */
    private $st_ativo;


    /**
     * Get sq_atendente
     *
     * @return integer 
     */
    public function getSqAtendente()
    {
        return $this->sq_atendente;
    }

    /**
     * Set sq_usuario
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuario
     * @return Atendente
     */
    public function setSqUsuario(\Core\OrthosBundle\Entity\Usuario $sqUsuario)
    {
        $this->sq_usuario = $sqUsuario;
    
        return $this;
    }

    /**
     * Get sq_usuario
     *
     * @return \Core\OrthosBundle\Entity\Usuario
     */
    public function getSqUsuario()
    {
        return $this->sq_usuario;
    }

    /**
     * Set st_ativo
     *
     * @param boolean $stAtivo
     * @return Atendente
     */
    public function setStAtivo($stAtivo)
    {
        $this->st_ativo = $stAtivo;
    
        return $this;
    }

    /**
     * Get st_ativo
     *
     * @return boolean
     */
    public function getStAtivo()
    {
        return $this->st_ativo;
    }

    /**
     * @param \Orthos\Bundle\AgendaBundle\Entity\Agenda $atendenteAgenda
     */
    public function setAtendenteAgenda (\Orthos\Bundle\AgendaBundle\Entity\Agenda $atendenteAgenda)
    {
        $this->atendenteAgenda = $atendenteAgenda;
    }

    /**
     * @return \Orthos\Bundle\AgendaBundle\Entity\Agenda
     */
    public function getAtendenteAgenda ()
    {
        return $this->atendenteAgenda;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Clinica $sq_clinica
     */
    public function setSqClinica ($sq_clinica)
    {
        $this->sq_clinica = $sq_clinica;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     */
    public function getSqClinica ()
    {
        return $this->sq_clinica;
    }
}
