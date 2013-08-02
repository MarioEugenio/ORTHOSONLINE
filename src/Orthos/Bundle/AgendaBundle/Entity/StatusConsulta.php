<?php

namespace Orthos\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatusConsulta
 *
 * @ORM\Table(name="tb_status_consulta")
 * @ORM\Entity
 */
class StatusConsulta extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_status_consulta", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_status_consulta;

    /**
     * @var string
     *
     * @ORM\Column(name="no_status", type="string", length=255)
     */
    private $no_status;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_cor_status", type="string", length=7)
     */
    private $ds_cor_status;


    /**
     * Get sq_status_consulta
     *
     * @return integer 
     */
    public function getStatusConsulta()
    {
        return $this->sq_status_consulta;
    }

    /**
     * Set no_status
     *
     * @param string $noStatus
     * @return StatusConsulta
     */
    public function setNoStatus($noStatus)
    {
        $this->no_status = $noStatus;
    
        return $this;
    }

    /**
     * Get no_status
     *
     * @return string 
     */
    public function getNoStatus()
    {
        return $this->no_status;
    }

    /**
     * Set ds_cor_status
     *
     * @param string $dsCorStatus
     * @return StatusConsulta
     */
    public function setDsCorStatus($dsCorStatus)
    {
        $this->ds_cor_status = $dsCorStatus;
    
        return $this;
    }

    /**
     * Get ds_cor_status
     *
     * @return string 
     */
    public function getDsCorStatus()
    {
        return $this->ds_cor_status;
    }
}
