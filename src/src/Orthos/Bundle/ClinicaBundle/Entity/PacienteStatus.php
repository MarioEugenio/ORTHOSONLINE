<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteStatus
 *
 * @ORM\Table(name="tb_paciente_status")
 * @ORM\Entity
 */
class PacienteStatus extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_paciente_status", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_paciente_status;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_status_father", referencedColumnName="sq_paciente_status")
     * })
     */
    private $sq_status_father;

    /**
     * @var string
     *
     * @ORM\Column(name="no_status", type="string", length=100)
     */
    private $no_status;


    /**
     * Get sq_paciente_status
     *
     * @return integer 
     */
    public function getSqStatus()
    {
        return $this->sq_paciente_status;
    }

    /**
     * Set no_status
     *
     * @param string $noStatus
     * @return PacienteStatus
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
     * @param \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus $sq_status_father
     */
    public function setSqStatusFather($sq_status_father)
    {
        $this->sq_status_father = $sq_status_father;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus
     */
    public function getSqStatusFather()
    {
        return $this->sq_status_father;
    }
}
