<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Convenio
 *
 * @ORM\Table(name="tb_convenio")
 * @ORM\Entity
 */
class Convenio extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_convenio", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_convenio;

    /**
     * @var string
     *
     * @ORM\Column(name="no_convenio", type="string", length=255)
     */
    private $no_convenio;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_convenio", type="string", length=400)
     */
    private $ds_convenio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;


    /**
     * Set no_convenio
     *
     * @param string $noConvenio
     * @return Convenio
     */
    public function setNoConvenio($noConvenio)
    {
        $this->no_convenio = $noConvenio;
    
        return $this;
    }

    /**
     * Get no_convenio
     *
     * @return string 
     */
    public function getNoConvenio()
    {
        return $this->no_convenio;
    }

    /**
     * Set ds_convenio
     *
     * @param string $dsConvenio
     * @return Convenio
     */
    public function setDsConvenio($dsConvenio)
    {
        $this->ds_convenio = $dsConvenio;
    
        return $this;
    }

    /**
     * Get ds_convenio
     *
     * @return string 
     */
    public function getDsConvenio()
    {
        return $this->ds_convenio;
    }

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return Convenio
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
     * @param int $sq_convenio
     */
    public function setSqConvenio ($sq_convenio)
    {
        $this->sq_convenio = $sq_convenio;
    }

    /**
     * @return int
     */
    public function getSqConvenio ()
    {
        return $this->sq_convenio;
    }
}
