<?php

namespace Orthos\Bundle\NewslatterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeloDocumento
 *
 * @ORM\Table(name="tb_modelo_documento")
 * @ORM\Entity
 */
class ModeloDocumento extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_modelo_documento", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_modelo_documento;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_header", type="text")
     */
    private $tx_header;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_body", type="text")
     */
    private $tx_body;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_footer", type="text")
     */
    private $tx_footer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="date")
     */
    private $dt_cadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="no_modelo", type="string", length=255)
     */
    private $no_modelo;

    /**
     * @var float
     *
     * @ORM\Column(name="fl_ativo", type="float")
     */
    private $fl_ativo;


    /**
     * Get sq_modelo_documento
     *
     * @return integer 
     */
    public function getSqModeloDocumento()
    {
        return $this->sq_modelo_documento;
    }

    /**
     * Set tx_header
     *
     * @param string $txHeader
     * @return ModeloDocumento
     */
    public function setTxHeader($txHeader)
    {
        $this->tx_header = $txHeader;
    
        return $this;
    }

    /**
     * Get tx_header
     *
     * @return string 
     */
    public function getTxHeader()
    {
        return $this->tx_header;
    }

    /**
     * Set tx_body
     *
     * @param string $txBody
     * @return ModeloDocumento
     */
    public function setTxBody($txBody)
    {
        $this->tx_body = $txBody;
    
        return $this;
    }

    /**
     * Get tx_body
     *
     * @return string 
     */
    public function getTxBody()
    {
        return $this->tx_body;
    }

    /**
     * Set tx_footer
     *
     * @param string $txFooter
     * @return ModeloDocumento
     */
    public function setTxFooter($txFooter)
    {
        $this->tx_footer = $txFooter;
    
        return $this;
    }

    /**
     * Get tx_footer
     *
     * @return string 
     */
    public function getTxFooter()
    {
        return $this->tx_footer;
    }

    /**
     * Set dt_cadastro
     *
     * @param \DateTime $dtCadastro
     * @return ModeloDocumento
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
     * Set no_modelo
     *
     * @param string $noModelo
     * @return ModeloDocumento
     */
    public function setNoModelo($noModelo)
    {
        $this->no_modelo = $noModelo;
    
        return $this;
    }

    /**
     * Get no_modelo
     *
     * @return string 
     */
    public function getNoModelo()
    {
        return $this->no_modelo;
    }

    /**
     * Set fl_ativo
     *
     * @param float $flAtivo
     * @return ModeloDocumento
     */
    public function setFlAtivo($flAtivo)
    {
        $this->fl_ativo = $flAtivo;
    
        return $this;
    }

    /**
     * Get fl_ativo
     *
     * @return float 
     */
    public function getFlAtivo()
    {
        return $this->fl_ativo;
    }
}
