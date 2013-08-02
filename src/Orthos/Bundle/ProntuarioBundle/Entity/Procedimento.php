<?php

namespace Orthos\Bundle\ProntuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Procedimento
 *
 * @ORM\Table(name="tb_procedimento")
 * @ORM\Entity
 */
class Procedimento extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_procedimento", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_procedimento;

    /**
     * @var  \Core\OrthosBundle\Entity\Especialidade
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Especialidade")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_especialidade", referencedColumnName="sq_especialidade")
     * })
     */
    private $sq_especialidade;

    /**
     * @var string
     *
     * @ORM\Column(name="no_procedimento", type="string", length=100)
     */
    private $no_procedimento;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_procedimento", type="string", length=255, nullable=true)
     */
    private $ds_procedimento;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_image_procedimento", type="string", length=100, nullable=true)
     */
    private $ds_image_procedimento;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_procedimento", type="decimal", nullable=true)
     */
    private $vl_procedimento;

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
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;


    /**
     * Get sq_procedimento
     *
     * @return integer 
     */
    public function getSqProcedimento()
    {
        return $this->sq_procedimento;
    }

    /**
     * Set sq_especialidade
     *
     * @param \Core\OrthosBundle\Entity\Especialidade $sqEspecialidade
     * @return Procedimento
     */
    public function setSqEspecialidade(\Core\OrthosBundle\Entity\Especialidade $sqEspecialidade)
    {
        $this->sq_especialidade = $sqEspecialidade;
    
        return $this;
    }

    /**
     * Get sq_especialidade
     *
     * @return \Core\OrthosBundle\Entity\Especialidade
     */
    public function getSqEspecialidade()
    {
        return $this->sq_especialidade;
    }

    /**
     * Set no_procedimento
     *
     * @param string $noProcedimento
     * @return Procedimento
     */
    public function setNoProcedimento($noProcedimento)
    {
        $this->no_procedimento = $noProcedimento;
    
        return $this;
    }

    /**
     * Get no_procedimento
     *
     * @return string 
     */
    public function getNoProcedimento()
    {
        return $this->no_procedimento;
    }

    /**
     * Set ds_procedimento
     *
     * @param string $dsProcedimento
     * @return Procedimento
     */
    public function setDsProcedimento($dsProcedimento)
    {
        $this->ds_procedimento = $dsProcedimento;
    
        return $this;
    }

    /**
     * Get ds_procedimento
     *
     * @return string 
     */
    public function getDsProcedimento()
    {
        return $this->ds_procedimento;
    }

    /**
     * Set ds_image_procedimento
     *
     * @param string $dsImageProcedimento
     * @return Procedimento
     */
    public function setDsImageProcedimento($dsImageProcedimento)
    {
        $this->ds_image_procedimento = $dsImageProcedimento;
    
        return $this;
    }

    /**
     * Get ds_image_procedimento
     *
     * @return string 
     */
    public function getDsImageProcedimento()
    {
        return $this->ds_image_procedimento;
    }

    /**
     * Set vl_procedimento
     *
     * @param float $vlProcedimento
     * @return Procedimento
     */
    public function setVlProcedimento($vlProcedimento)
    {
        $this->vl_procedimento = $vlProcedimento;
    
        return $this;
    }

    /**
     * Get vl_procedimento
     *
     * @return float 
     */
    public function getVlProcedimento()
    {
        return $this->vl_procedimento;
    }

    /**
     * Set sq_clinica
     *
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Clinica $sqClinica
     * @return Procedimento
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

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return Procedimento
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
}
