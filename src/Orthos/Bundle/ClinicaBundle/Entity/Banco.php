<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banco
 *
 * @ORM\Table(name="tb_banco")
 * @ORM\Entity
 */
class Banco extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_banco", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_banco;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_banco", type="string", length=50)
     */
    private $nu_banco;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_agencia", type="string", length=50)
     */
    private $nu_agencia;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_conta", type="string", length=50)
     */
    private $nu_conta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="st_default", type="boolean", nullable=true)
     */
    private $st_default;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;

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
     * Get sq_banco
     *
     * @return integer 
     */
    public function getSqBanco()
    {
        return $this->sq_banco;
    }

    /**
     * Set nu_banco
     *
     * @param string $nuBanco
     * @return Banco
     */
    public function setNuBanco($nuBanco)
    {
        $this->nu_banco = $nuBanco;
    
        return $this;
    }

    /**
     * Get nu_banco
     *
     * @return string 
     */
    public function getNuBanco()
    {
        return $this->nu_banco;
    }

    /**
     * Set nu_agencia
     *
     * @param string $nuAgencia
     * @return Banco
     */
    public function setNuAgencia($nuAgencia)
    {
        $this->nu_agencia = $nuAgencia;
    
        return $this;
    }

    /**
     * Get nu_agencia
     *
     * @return string 
     */
    public function getNuAgencia()
    {
        return $this->nu_agencia;
    }

    /**
     * Set nu_conta
     *
     * @param string $nuConta
     * @return Banco
     */
    public function setNuConta($nuConta)
    {
        $this->nu_conta = $nuConta;
    
        return $this;
    }

    /**
     * Get nu_conta
     *
     * @return string 
     */
    public function getNuConta()
    {
        return $this->nu_conta;
    }

    /**
     * Set st_default
     *
     * @param boolean $stDefault
     * @return Banco
     */
    public function setStDefault($stDefault)
    {
        $this->st_default = $stDefault;
    
        return $this;
    }

    /**
     * Get st_default
     *
     * @return boolean 
     */
    public function getStDefault()
    {
        return $this->st_default;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Clinica $sq_clinica
     */
    public function setSqClinica (\Orthos\Bundle\ClinicaBundle\Entity\Clinica $sq_clinica)
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

    /**
     * @param boolean $fl_ativo
     */
    public function setFlAtivo ($fl_ativo)
    {
        $this->fl_ativo = $fl_ativo;
    }

    /**
     * @return boolean
     */
    public function getFlAtivo ()
    {
        return $this->fl_ativo;
    }
}
