<?php

namespace Orthos\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Agenda
 *
 * @ORM\Table(name="tb_agenda")
 * @ORM\Entity
 */
class Agenda extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_agenda", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_agenda;

    /**
     * @var string
     *
     * @ORM\Column(name="no_paciente", type="string", length=255)
     */
    private $no_paciente;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_paciente", type="string", length=50, nullable=true)
     */
    private $nu_paciente;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_row", type="integer")
     */
    private $nu_row;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_colunm", type="integer")
     */
    private $nu_colunm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inicio", type="datetime", nullable=true)
     */
    private $dt_inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_fim", type="datetime", nullable=true)
     */
    private $dt_fim;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime")
     */
    private $dt_cadastro;

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
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Cadeira
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Cadeira")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_cadeira", referencedColumnName="sq_cadeira")
     * })
     */
    private $sq_cadeira;

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
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_atendente", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_atendente;

    /**
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_medico", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_medico;

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
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_usuario_finaliza", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_usuario_finaliza;

    /**
     * @var  Orthos\Bundle\AgendaBundle\Entity\StatusConsulta
     *
     * @ORM\ManyToOne(targetEntity="Orthos\Bundle\AgendaBundle\Entity\StatusConsulta")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_status", referencedColumnName="sq_status_consulta")
     * })
     */
    private $sq_status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_finalizado", type="boolean", nullable=true)
     */
    private $fl_finalizado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_chegada", type="datetime", nullable=true)
     */
    private $dt_chegada;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_observacao", type="string", length=400, nullable=true)
     */
    private $tx_observacao;


    public function __construct(Array $data=NULL) {
        parent::__construct($data);
    }

    /**
     * Get sq_agenda
     *
     * @return integer 
     */
    public function getSqAgenda()
    {
        return $this->sq_agenda;
    }

    /**
     * Set no_paciente
     *
     * @param string $noPaciente
     * @return Agenda
     */
    public function setNoPaciente($noPaciente)
    {
        $this->no_paciente = $noPaciente;
    
        return $this;
    }

    /**
     * Get no_paciente
     *
     * @return string 
     */
    public function getNoPaciente()
    {
        return $this->no_paciente;
    }

    /**
     * Set dt_inicio
     *
     * @param \DateTime $dtInicio
     * @return Agenda
     */
    public function setDtInicio($dtInicio)
    {
        $this->dt_inicio = $dtInicio;
    
        return $this;
    }

    /**
     * Get dt_inicio
     *
     * @return \DateTime 
     */
    public function getDtInicio()
    {
        return $this->dt_inicio;
    }

    /**
     * Set dt_fim
     *
     * @param \DateTime $dtFim
     * @return Agenda
     */
    public function setDtFim($dtFim)
    {
        $this->dt_fim = $dtFim;
    
        return $this;
    }

    /**
     * Get dt_fim
     *
     * @return \DateTime 
     */
    public function getDtFim()
    {
        return $this->dt_fim;
    }

    /**
     * Set dt_cadastro
     *
     * @param \DateTime $dtCadastro
     * @return Agenda
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dt_cadastro = $dtCadastro;
    
        return $this;
    }

    /**
     * Get dt_cadastro
     *
     * @return \DateTime 
     */
    public function getDtCadastro()
    {
        return $this->dt_cadastro;
    }

    /**
     * Set sq_paciente
     *
     * @param integer $sqPaciente
     * @return Agenda
     */
    public function setSqPaciente($sqPaciente)
    {
        $this->sq_paciente = $sqPaciente;
    
        return $this;
    }

    /**
     * Get sq_paciente
     *
     * @return integer 
     */
    public function getSqPaciente()
    {
        return $this->sq_paciente;
    }

    /**
     * Set sq_clinica
     *
     * @param integer $sqClinica
     * @return Agenda
     */
    public function setSqClinica($sqClinica)
    {
        $this->sq_clinica = $sqClinica;
    
        return $this;
    }

    /**
     * Get sq_clinica
     *
     * @return integer 
     */
    public function getSqClinica()
    {
        return $this->sq_clinica;
    }

    /**
     * Set sq_cadeira
     *
     * @param integer $sqCadeira
     * @return Agenda
     */
    public function setSqCadeira($sqCadeira)
    {
        $this->sq_cadeira = $sqCadeira;

        return $this;
    }

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
     * Set sq_atendente
     *
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Atendente $sqAtendente
     * @return Agenda
     */
    public function setSqAtendente($sqAtendente)
    {
        $this->sq_atendente = $sqAtendente;
    
        return $this;
    }

    /**
     * Get sq_atendente
     *
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Atendente
     */
    public function getSqAtendente()
    {
        return $this->sq_atendente;
    }

    /**
     * Set sq_agenda
     *
     * @param integer $sqAgenda
     * @return Agenda
     */
    public function setSqAgenda($sqAgenda)
    {
        $this->sq_agenda = $sqAgenda;
    
        return $this;
    }

    /**
     * Set sq_usuario
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuario
     * @return Agenda
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
     * Set sq_usuario_finaliza
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuarioFinaliza
     * @return Agenda
     */
    public function setSqUsuarioFinaliza(\Core\OrthosBundle\Entity\Usuario $sqUsuarioFinaliza)
    {
        $this->sq_usuario_finaliza = $sqUsuarioFinaliza;
    
        return $this;
    }

    /**
     * Get sq_usuario_finaliza
     *
     * @return \Core\OrthosBundle\Entity\Usuario
     */
    public function getSqUsuarioFinaliza()
    {
        return $this->sq_usuario_finaliza;
    }

    /**
     * @param \DateTime $dt_chegada
     */
    public function setDtChegada ($dt_chegada)
    {
        $this->dt_chegada = $dt_chegada;
    }

    /**
     * @return \DateTime
     */
    public function getDtChegada ()
    {
        return $this->dt_chegada;
    }

    /**
     * @param boolean $fl_finalizado
     */
    public function setFlFinalizado ($fl_finalizado)
    {
        $this->fl_finalizado = $fl_finalizado;
    }

    /**
     * @return boolean
     */
    public function getFlFinalizado ()
    {
        return $this->fl_finalizado;
    }

    /**
     * @param \Orthos\Bundle\AgendaBundle\Entity\StatusConsulta $sq_status
     */
    public function setSqStatus ($sq_status)
    {
        $this->sq_status = $sq_status;
    }

    /**
     * @return \Orthos\Bundle\AgendaBundle\Entity\StatusConsulta
     */
    public function getSqStatus ()
    {
        return $this->sq_status;
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

    /**
     * @param int $nu_colunm
     */
    public function setNuColunm ($nu_colunm)
    {
        $this->nu_colunm = $nu_colunm;
    }

    /**
     * @return int
     */
    public function getNuColunm ()
    {
        return $this->nu_colunm;
    }

    /**
     * @param int $nu_row
     */
    public function setNuRow ($nu_row)
    {
        $this->nu_row = $nu_row;
    }

    /**
     * @return int
     */
    public function getNuRow ()
    {
        return $this->nu_row;
    }

    /**
     * @param \Core\OrthosBundle\Entity\Usuario $sq_medico
     */
    public function setSqMedico ($sq_medico)
    {
        $this->sq_medico = $sq_medico;
    }

    /**
     * @return \Core\OrthosBundle\Entity\Usuario
     */
    public function getSqMedico ()
    {
        return $this->sq_medico;
    }

    /**
     * @param int $nu_paciente
     */
    public function setNuPaciente ($nu_paciente)
    {
        $this->nu_paciente = $nu_paciente;
    }

    /**
     * @return int
     */
    public function getNuPaciente ()
    {
        return $this->nu_paciente;
    }
}
