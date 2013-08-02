<?php

namespace Orthos\Bundle\NewslatterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newslatter
 *
 * @ORM\Table(name="tb_newslatter")
 * @ORM\Entity
 */
class Newslatter extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_newslatter", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_newslatter;

    /**
     * @var string
     *
     * @ORM\Column(name="no_newslatter", type="string", length=255)
     */
    private $no_newslatter;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="date")
     */
    private $dt_cadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_envio", type="date")
     */
    private $dt_envio;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_descricao", type="string", length=400)
     */
    private $tx_descricao;

    /**
     * @var  \Orthos\Bundle\NewslatterBundle\Entity\ModeloDocumento
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\NewslatterBundle\Entity\ModeloDocumento")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_modelo_documento", referencedColumnName="sq_modelo_documento")
     * })
     */
    private $sq_modelo_documento;

    /**
     * Get sq_newslatter
     *
     * @return integer 
     */
    public function getSqNewslatter()
    {
        return $this->sq_newslatter;
    }

    /**
     * Set no_newslatter
     *
     * @param string $noNewslatter
     * @return Newslatter
     */
    public function setNoNewslatter($noNewslatter)
    {
        $this->no_newslatter = $noNewslatter;
    
        return $this;
    }

    /**
     * Get no_newslatter
     *
     * @return string 
     */
    public function getNoNewslatter()
    {
        return $this->no_newslatter;
    }

    /**
     * Set dt_cadastro
     *
     * @param \DateTime $dtCadastro
     * @return Newslatter
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
     * Set dt_envio
     *
     * @param \DateTime $dtEnvio
     * @return Newslatter
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
     * Set tx_descricao
     *
     * @param string $txDescricao
     * @return Newslatter
     */
    public function setTxDescricao($txDescricao)
    {
        $this->tx_descricao = $txDescricao;
    
        return $this;
    }

    /**
     * Get tx_descricao
     *
     * @return string 
     */
    public function getTxDescricao()
    {
        return $this->tx_descricao;
    }

    /**
     * @param \Orthos\Bundle\NewslatterBundle\Entity\ModeloDocumento $sq_modelo_documento
     */
    public function setSqModeloDocumento ($sq_modelo_documento)
    {
        $this->sq_modelo_documento = $sq_modelo_documento;
    }

    /**
     * @return \Orthos\Bundle\NewslatterBundle\Entity\ModeloDocumento
     */
    public function getSqModeloDocumento ()
    {
        return $this->sq_modelo_documento;
    }
}
