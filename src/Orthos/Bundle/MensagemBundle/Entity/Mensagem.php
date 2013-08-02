<?php

namespace Orthos\Bundle\MensagemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensagem
 *
 * @ORM\Table(name="tb_mensagem")
 * @ORM\Entity
 */
class Mensagem extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_mensagem", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_mensagem;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_tipo_mensagem", type="string", length=1)
     */
    private $fl_tipo_mensagem;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_assunto", type="string", length=100)
     */
    private $tx_assunto;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_mensagem", type="string", length=400)
     */
    private $tx_mensagem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_enviada", type="boolean")
     */
    private $fl_enviada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_envio", type="datetime")
     */
    private $dt_envio;

    /** @var  \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Paciente")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_paciente", referencedColumnName="sq_paciente")
     * })
     */
    private $sq_paciente;


    /**
     * Set fl_tipo_mensagem
     *
     * @param string $flTipoMensagem
     * @return Mensagem
     */
    public function setFlTipoMensagem($flTipoMensagem)
    {
        $this->fl_tipo_mensagem = $flTipoMensagem;
    
        return $this;
    }

    /**
     * Get fl_tipo_mensagem
     *
     * @return string 
     */
    public function getFlTipoMensagem()
    {
        return $this->fl_tipo_mensagem;
    }

    /**
     * Set tx_assunto
     *
     * @param string $txAssunto
     * @return Mensagem
     */
    public function setTxAssunto($txAssunto)
    {
        $this->tx_assunto = $txAssunto;
    
        return $this;
    }

    /**
     * Get tx_assunto
     *
     * @return string 
     */
    public function getTxAssunto()
    {
        return $this->tx_assunto;
    }

    /**
     * Set tx_mensagem
     *
     * @param string $txMensagem
     * @return Mensagem
     */
    public function setTxMensagem($txMensagem)
    {
        $this->tx_mensagem = $txMensagem;
    
        return $this;
    }

    /**
     * Get tx_mensagem
     *
     * @return string 
     */
    public function getTxMensagem()
    {
        return $this->tx_mensagem;
    }

    /**
     * Set fl_enviada
     *
     * @param boolean $flEnviada
     * @return Mensagem
     */
    public function setFlEnviada($flEnviada)
    {
        $this->fl_enviada = $flEnviada;
    
        return $this;
    }

    /**
     * Get fl_enviada
     *
     * @return boolean 
     */
    public function getFlEnviada()
    {
        return $this->fl_enviada;
    }

    /**
     * Set dt_envio
     *
     * @param \DateTime $dtEnvio
     * @return Mensagem
     */
    public function setDtEnvio($dtEnvio)
    {
        $this->dt_envio = $dtEnvio;
    
        return $this;
    }

    /**
     * Get dt_envio
     *
     * @return \DateTime 
     */
    public function getDtEnvio()
    {
        return $this->dt_envio;
    }

    /**
     * @param int $sq_mensagem
     */
    public function setSqMensagem ($sq_mensagem)
    {
        $this->sq_mensagem = $sq_mensagem;
    }

    /**
     * @return int
     */
    public function getSqMensagem ()
    {
        return $this->sq_mensagem;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Paciente $sq_paciente
     */
    public function setSqPaciente ($sq_paciente)
    {
        $this->sq_paciente = $sq_paciente;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     */
    public function getSqPaciente ()
    {
        return $this->sq_paciente;
    }
}
