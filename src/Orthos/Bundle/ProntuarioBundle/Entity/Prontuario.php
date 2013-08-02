<?php

namespace Orthos\Bundle\ProntuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prontuario
 *
 * @ORM\Table(name="tb_prontuario")
 * @ORM\Entity
 */
class Prontuario extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_prontuario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_prontuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_procedimento", type="date")
     */
    private $dt_procedimento;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Paciente")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_paciente", referencedColumnName="sq_paciente")
     * })
     */
    private $sq_paciente;

    /**
     * @var  \Orthos\Bundle\AgendaBundle\Entity\Agenda
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\AgendaBundle\Entity\Agenda")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_agenda", referencedColumnName="sq_agenda")
     * })
     */
    private $sq_agenda;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_prontuario_realizado", type="string", length=255, nullable=true)
     */
    private $ds_prontuario_realizado;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_prontuario_arealizar", type="string", length=255, nullable=true)
     */
    private $ds_prontuario_arealizar;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_observacao", type="string", length=255, nullable=true)
     */
    private $tx_observacao;

    /**
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_usuario", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_usuario;

    private $dt_inicial;

    private $dt_final;


    /**
     * Get sq_prontuario
     *
     * @return integer 
     */
    public function getSqProntuario()
    {
        return $this->sq_prontuario;
    }

    /**
     * Set dt_procedimento
     *
     * @param \DateTime $dtProcedimento
     * @return Prontuario
     */
    public function setDtProcedimento($dtProcedimento)
    {
        $this->dt_procedimento = $dtProcedimento;
    
        return $this;
    }

    /**
     * Get dt_procedimento
     *
     * @return \DateTime 
     */
    public function getDtProcedimento()
    {
        return $this->dt_procedimento;
    }

    /**
     * Set sq_paciente
     *
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Paciente $sqPaciente
     * @return Prontuario
     */
    public function setSqPaciente(\Orthos\Bundle\ClinicaBundle\Entity\Paciente $sqPaciente)
    {
        $this->sq_paciente = $sqPaciente;
    
        return $this;
    }

    /**
     * Get sq_paciente
     *
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     */
    public function getSqPaciente()
    {
        return $this->sq_paciente;
    }

    /**
     * Set sq_usuario
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuario
     * @return Prontuario
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

    public function setDtFinal ($dt_final)
    {
        $this->dt_final = $dt_final;
    }

    public function getDtFinal ()
    {
        return $this->dt_final;
    }

    public function setDtInicial ($dt_inicial)
    {
        $this->dt_inicial = $dt_inicial;
    }

    public function getDtInicial ()
    {
        return $this->dt_inicial;
    }

    /**
     * @param \Orthos\Bundle\AgendaBundle\Entity\Agenda $sq_agenda
     */
    public function setSqAgenda ($sq_agenda)
    {
        $this->sq_agenda = $sq_agenda;
    }

    /**
     * @return \Orthos\Bundle\AgendaBundle\Entity\Agenda
     */
    public function getSqAgenda ()
    {
        return $this->sq_agenda;
    }

    /**
     * @param string $ds_prontuario_arealizar
     */
    public function setDsProntuarioArealizar ($ds_prontuario_arealizar)
    {
        $this->ds_prontuario_arealizar = $ds_prontuario_arealizar;
    }

    /**
     * @return string
     */
    public function getDsProntuarioArealizar ()
    {
        return $this->ds_prontuario_arealizar;
    }

    /**
     * @param string $ds_prontuario_realizado
     */
    public function setDsProntuarioRealizado ($ds_prontuario_realizado)
    {
        $this->ds_prontuario_realizado = $ds_prontuario_realizado;
    }

    /**
     * @return string
     */
    public function getDsProntuarioRealizado ()
    {
        return $this->ds_prontuario_realizado;
    }

    /**
     * @param string $tx_observacao
     */
    public function setTxObservacao ($tx_observacao)
    {
        $this->tx_observacao = $tx_observacao;
    }

    /**
     * @return string
     */
    public function getTxObservacao ()
    {
        return $this->tx_observacao;
    }
}
