<?php

namespace Orthos\Bundle\NewslatterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewslatterEnvio
 *
 * @ORM\Table(name="tb_newslatter_envio")
 * @ORM\Entity
 */
class NewslatterEnvio extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_newslatter_envio", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_newslatter_envio;

    /**
     * @var string
     *
     * @ORM\Column(name="no_destinatario", type="string", length=255)
     */
    private $no_destinatario;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_email", type="string", length=255)
     */
    private $tx_email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_envio", type="boolean")
     */
    private $fl_envio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_envio", type="datetime")
     */
    private $dt_envio;

    /**
     * @var  \Orthos\Bundle\NewslatterBundle\Entity\Newslatter
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\NewslatterBundle\Entity\Newslatter")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_newslatter", referencedColumnName="sq_newslatter")
     * })
     */
    private $sq_newslatter;


    /**
     * Get sq_newslatter_envio
     *
     * @return integer 
     */
    public function getSqNewslatterEnvio()
    {
        return $this->sq_newslatter_envio;
    }

    /**
     * Set no_destinatario
     *
     * @param string $noDestinatario
     * @return NewslatterEnvio
     */
    public function setNoDestinatario($noDestinatario)
    {
        $this->no_destinatario = $noDestinatario;
    
        return $this;
    }

    /**
     * Get no_destinatario
     *
     * @return string 
     */
    public function getNoDestinatario()
    {
        return $this->no_destinatario;
    }

    /**
     * Set tx_email
     *
     * @param string $txEmail
     * @return NewslatterEnvio
     */
    public function setTxEmail($txEmail)
    {
        $this->tx_email = $txEmail;
    
        return $this;
    }

    /**
     * Get tx_email
     *
     * @return string 
     */
    public function getTxEmail()
    {
        return $this->tx_email;
    }

    /**
     * Set fl_envio
     *
     * @param boolean $flEnvio
     * @return NewslatterEnvio
     */
    public function setFlEnvio($flEnvio)
    {
        $this->fl_envio = $flEnvio;
    
        return $this;
    }

    /**
     * Get fl_envio
     *
     * @return boolean 
     */
    public function getFlEnvio()
    {
        return $this->fl_envio;
    }

    /**
     * Set dt_envio
     *
     * @param \DateTime $dtEnvio
     * @return NewslatterEnvio
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
     * @param \Orthos\Bundle\NewslatterBundle\Entity\Newslatter $sq_newslatter
     */
    public function setSqNewslatter ($sq_newslatter)
    {
        $this->sq_newslatter = $sq_newslatter;
    }

    /**
     * @return \Orthos\Bundle\NewslatterBundle\Entity\Newslatter
     */
    public function getSqNewslatter ()
    {
        return $this->sq_newslatter;
    }
}
