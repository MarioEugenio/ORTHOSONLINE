<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clinica
 *
 * @ORM\Table(name="tb_clinica")
 * @ORM\Entity
 */
class Clinica extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_clinica", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_clinica;

    /**
     * @var string
     *
     * @ORM\Column(name="no_clinica", type="string", length=255)
     */
    private $no_clinica;

    /**
     * @var string
     *
     * @ORM\Column(name="no_razao_social", type="string", length=255, nullable=true)
     */
    private $no_razao_social;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_cnpj", type="string", length=50)
     */
    private $nu_cnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_endereco", type="string", length=255)
     */
    private $tx_endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="no_cidade", type="string", length=255)
     */
    private $no_cidade;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_uf", type="string", length=2)
     */
    private $tx_uf;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_email_clinica", type="string", length=255)
     */
    private $ds_email_clinica;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_telefone", type="string", length=20, nullable=true)
     */
    private $nu_telefone;

    /**
     * @var string
     *
     * @ORM\Column(name="no_contato", type="string", length=255, nullable=true)
     */
    private $no_contato;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_fax", type="string", length=20, nullable=true)
     */
    private $nu_fax;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_clm", type="string", length=50, nullable=true)
     */
    private $nu_clm;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_intervalo", type="string", length=5, nullable=true)
     */
    private $nu_intervalo;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_juros", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $nu_juros;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_boleto", type="string", length=100, nullable=true)
     */
    private $tx_boleto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean", nullable=true)
     */
    private $fl_ativo;


    private $fl_default;


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
     * Set no_clinica
     *
     * @param string $noClinica
     * @return Clinica
     */
    public function setNoClinica($noClinica)
    {
        $this->no_clinica = $noClinica;
    
        return $this;
    }

    /**
     * Get no_clinica
     *
     * @return string 
     */
    public function getNoClinica()
    {
        return $this->no_clinica;
    }

    /**
     * Set nu_cnpj
     *
     * @param string $nuCnpj
     * @return Clinica
     */
    public function setNuCnpj($nuCnpj)
    {
        $this->nu_cnpj = $nuCnpj;
    
        return $this;
    }

    /**
     * Get nu_cnpj
     *
     * @return string 
     */
    public function getNuCnpj()
    {
        return $this->nu_cnpj;
    }

    /**
     * Set ds_email_clinica
     *
     * @param string $dsEmailClinica
     * @return Clinica
     */
    public function setDsEmailClinica($dsEmailClinica)
    {
        $this->ds_email_clinica = $dsEmailClinica;
    
        return $this;
    }

    /**
     * Get ds_email_clinica
     *
     * @return string 
     */
    public function getDsEmailClinica()
    {
        return $this->ds_email_clinica;
    }

    /**
     * Set nu_telefone
     *
     * @param string $nuTelefone
     * @return Clinica
     */
    public function setNuTelefone($nuTelefone)
    {
        $this->nu_telefone = $nuTelefone;
    
        return $this;
    }

    /**
     * Get nu_telefone
     *
     * @return string 
     */
    public function getNuTelefone()
    {
        return $this->nu_telefone;
    }

    /**
     * Set no_contato
     *
     * @param string $noContato
     * @return Clinica
     */
    public function setNoContato($noContato)
    {
        $this->no_contato = $noContato;
    
        return $this;
    }

    /**
     * Get no_contato
     *
     * @return string 
     */
    public function getNoContato()
    {
        return $this->no_contato;
    }

    /**
     * Set nu_fax
     *
     * @param string $nuFax
     * @return Clinica
     */
    public function setNuFax($nuFax)
    {
        $this->nu_fax = $nuFax;
    
        return $this;
    }

    /**
     * Get nu_fax
     *
     * @return string 
     */
    public function getNuFax()
    {
        return $this->nu_fax;
    }

    /**
     * Set nu_clm
     *
     * @param string $nuClm
     * @return Clinica
     */
    public function setNuClm($nuClm)
    {
        $this->nu_clm = $nuClm;
    
        return $this;
    }

    /**
     * Get nu_clm
     *
     * @return string 
     */
    public function getNuClm()
    {
        return $this->nu_clm;
    }

    /**
     * @param string $nu_intervalo
     */
    public function setNuIntervalo ($nu_intervalo)
    {
        $this->nu_intervalo = $nu_intervalo;
    }

    /**
     * @return string
     */
    public function getNuIntervalo ()
    {
        return $this->nu_intervalo;
    }

    /**
     * @param string $no_razao_social
     */
    public function setNoRazaoSocial ($no_razao_social)
    {
        $this->no_razao_social = $no_razao_social;
    }

    /**
     * @return string
     */
    public function getNoRazaoSocial ()
    {
        return $this->no_razao_social;
    }

    /**
     * @param string $tx_boleto
     */
    public function setTxBoleto ($tx_boleto)
    {
        $this->tx_boleto = $tx_boleto;
    }

    /**
     * @return string
     */
    public function getTxBoleto ()
    {
        return $this->tx_boleto;
    }

    /**
     * @param boolean $fl_ativo
     */
    public function setFlAtivo ($fl_ativo)
    {
        $this->fl_ativo = $fl_ativo;
    }

    /**
     * @return boolean
     */
    public function getFlAtivo ()
    {
        return $this->fl_ativo;
    }

    public function setFlDefault ($fl_default)
    {
        $this->fl_default = $fl_default;
    }

    public function getFlDefault ()
    {
        return $this->fl_default;
    }

    /**
     * @param string $nu_juros
     */
    public function setNuJuros ($nu_juros)
    {
        $this->nu_juros = $nu_juros;
    }

    /**
     * @return string
     */
    public function getNuJuros ()
    {
        return $this->nu_juros;
    }

    /**
     * @param string $no_cidade
     */
    public function setNoCidade ($no_cidade)
    {
        $this->no_cidade = $no_cidade;
    }

    /**
     * @return string
     */
    public function getNoCidade ()
    {
        return $this->no_cidade;
    }

    /**
     * @param string $tx_endereco
     */
    public function setTxEndereco ($tx_endereco)
    {
        $this->tx_endereco = $tx_endereco;
    }

    /**
     * @return string
     */
    public function getTxEndereco ()
    {
        return $this->tx_endereco;
    }

    /**
     * @param string $tx_uf
     */
    public function setTxUf ($tx_uf)
    {
        $this->tx_uf = $tx_uf;
    }

    /**
     * @return string
     */
    public function getTxUf ()
    {
        return $this->tx_uf;
    }
}
