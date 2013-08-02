<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cadeira
 *
 * @ORM\Table(name="tb_cadeira")
 * @ORM\Entity
 */
class Cadeira extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_cadeira", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_cadeira;

    /**
     * @var string
     *
     * @ORM\Column(name="no_cadeira", type="string", length=50)
     */
    private $no_cadeira;

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
     * Get sq_cadeira
     *
     * @return integer 
     */
    public function getSqCadeira()
    {
        return $this->sq_cadeira;
    }

    /**
     * Set no_cadeira
     *
     * @param string $noCadeira
     * @return Cadeira
     */
    public function setNoCadeira($noCadeira)
    {
        $this->no_cadeira = $noCadeira;
    
        return $this;
    }

    /**
     * Get no_cadeira
     *
     * @return string 
     */
    public function getNoCadeira()
    {
        return $this->no_cadeira;
    }

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return Cadeira
     */
    public function setFlAtivo($flAtivo)
    {
        $this->fl_ativo = $flAtivo;
    
        return $this;
    }

    /**
     * Get fl_ativo
     *
     * @return boolean 
     */
    public function getFlAtivo()
    {
        return $this->fl_ativo;
    }

    /**
     * Set sq_clinica
     *
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Clinica $sqClinica
     * @return Cadeira
     */
    public function setSqClinica(\Orthos\Bundle\ClinicaBundle\Entity\Clinica $sqClinica)
    {
        $this->sq_clinica = $sqClinica;
    
        return $this;
    }

    /**
     * Get sq_clinica
     *
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     */
    public function getSqClinica()
    {
        return $this->sq_clinica;
    }
}
