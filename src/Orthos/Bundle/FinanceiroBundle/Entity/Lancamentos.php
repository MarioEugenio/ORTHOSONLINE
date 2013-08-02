<?php

namespace Orthos\Bundle\FinanceiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lancamentos
 *
 * @ORM\Table(name="tb_lancamentos")
 * @ORM\Entity
 */
class Lancamentos extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_lancamentos", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_lancamentos;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Banco
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Banco")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_banco", referencedColumnName="sq_banco")
     * })
     */
    private $sq_banco;

    /**
     * @var  \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_fornecedor", referencedColumnName="sq_fornecedor")
     * })
     */
    private $sq_fornecedor;

    /**
     * @var  \Orthos\Bundle\FinanceiroBundle\Entity\LancamentosCategoria
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\FinanceiroBundle\Entity\LancamentosCategoria")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_lancamentos_categoria", referencedColumnName="sq_lancamentos_categoria")
     * })
     */
    private $sq_lancamentos_categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_documento", type="string", length=50, nullable=true)
     */
    private $nu_documento;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_tipo_documento", type="string", length=2)
     */
    private $fl_tipo_documento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="date")
     */
    private $dt_cadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_emissao", type="date")
     */
    private $dt_emissao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_vencimento", type="date", nullable=true)
     */
    private $dt_vencimento;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_nominal", type="decimal", precision=12, scale=2)
     */
    private $vl_nominal;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_desconto", type="decimal", nullable=true, precision=12, scale=2)
     */
    private $vl_desconto;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_observacao", type="string", length=400, nullable=true)
     */
    private $tx_observacao;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_tipo_movimento", type="string", length=1)
     */
    private $fl_tipo_movimento;

    private $dt_inicio;

    private $dt_fim;


    /**
     * Get sq_lancamentos
     *
     * @return integer 
     */
    public function getSqLancamentos()
    {
        return $this->sq_lancamentos;
    }

    /**
     * Set sq_banco
     *
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Banco $sqBanco
     * @return Lancamentos
     */
    public function setSqBanco(\Orthos\Bundle\ClinicaBundle\Entity\Banco $sqBanco)
    {
        $this->sq_banco = $sqBanco;
    
        return $this;
    }

    /**
     * Get sq_banco
     *
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Banco
     */
    public function getSqBanco()
    {
        return $this->sq_banco;
    }

    /**
     * Set sq_fornecedor
     *
     * @param \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor $sqFornecedor
     * @return Lancamentos
     */
    public function setSqFornecedor(\Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor $sqFornecedor)
    {
        $this->sq_fornecedor = $sqFornecedor;
    
        return $this;
    }

    /**
     * Get sq_fornecedor
     *
     * @return \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor
     */
    public function getSqFornecedor()
    {
        return $this->sq_fornecedor;
    }

    /**
     * Set nu_documento
     *
     * @param string $nuDocumento
     * @return Lancamentos
     */
    public function setNuDocumento($nuDocumento)
    {
        $this->nu_documento = $nuDocumento;
    
        return $this;
    }

    /**
     * Get nu_documento
     *
     * @return string 
     */
    public function getNuDocumento()
    {
        return $this->nu_documento;
    }

    /**
     * Set fl_tipo_documento
     *
     * @param string $flTipoDocumento
     * @return Lancamentos
     */
    public function setFlTipoDocumento($flTipoDocumento)
    {
        $this->fl_tipo_documento = $flTipoDocumento;
    
        return $this;
    }

    /**
     * Get fl_tipo_documento
     *
     * @return string 
     */
    public function getFlTipoDocumento()
    {
        return $this->fl_tipo_documento;
    }

    /**
     * Set dt_emissao
     *
     * @param \DateTime $dtEmissao
     * @return Lancamentos
     */
    public function setDtEmissao($dtEmissao)
    {
        $this->dt_emissao = $dtEmissao;
    
        return $this;
    }

    /**
     * Get dt_emissao
     *
     * @return \DateTime 
     */
    public function getDtEmissao()
    {
        return $this->dt_emissao;
    }

    /**
     * Set dt_vencimento
     *
     * @param \DateTime $dtVencimento
     * @return Lancamentos
     */
    public function setDtVencimento($dtVencimento)
    {
        $this->dt_vencimento = $dtVencimento;
    
        return $this;
    }

    /**
     * Get dt_vencimento
     *
     * @return \DateTime 
     */
    public function getDtVencimento()
    {
        return $this->dt_vencimento;
    }

    /**
     * Set vl_nominal
     *
     * @param float $vlNominal
     * @return Lancamentos
     */
    public function setVlNominal($vlNominal)
    {
        $this->vl_nominal = $vlNominal;
    
        return $this;
    }

    /**
     * Get vl_nominal
     *
     * @return float 
     */
    public function getVlNominal()
    {
        return $this->vl_nominal;
    }

    /**
     * Set vl_desconto
     *
     * @param float $vlDesconto
     * @return Lancamentos
     */
    public function setVlDesconto($vlDesconto)
    {
        $this->vl_desconto = $vlDesconto;
    
        return $this;
    }

    /**
     * Get vl_desconto
     *
     * @return float 
     */
    public function getVlDesconto()
    {
        return $this->vl_desconto;
    }

    /**
     * Set tx_observacao
     *
     * @param string $txObservacao
     * @return Lancamentos
     */
    public function setTxObservacao($txObservacao)
    {
        $this->tx_observacao = $txObservacao;
    
        return $this;
    }

    /**
     * Get tx_observacao
     *
     * @return string 
     */
    public function getTxObservacao()
    {
        return $this->tx_observacao;
    }

    /**
     * Set fl_tipo_movimento
     *
     * @param string $flTipoMovimento
     * @return Lancamentos
     */
    public function setFlTipoMovimento($flTipoMovimento)
    {
        $this->fl_tipo_movimento = $flTipoMovimento;
    
        return $this;
    }

    /**
     * Get fl_tipo_movimento
     *
     * @return string 
     */
    public function getFlTipoMovimento()
    {
        return $this->fl_tipo_movimento;
    }

    /**
     * @param \DateTime $dt_cadastro
     */
    public function setDtCadastro ($dt_cadastro)
    {
        $this->dt_cadastro = $dt_cadastro;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro ()
    {
        return $this->dt_cadastro;
    }

    public function setDtFim ($dt_fim)
    {
        $this->dt_fim = $dt_fim;
    }

    public function getDtFim ()
    {
        return $this->dt_fim;
    }

    public function setDtInicio ($dt_inicio)
    {
        $this->dt_inicio = $dt_inicio;
    }

    public function getDtInicio ()
    {
        return $this->dt_inicio;
    }

    /**
     * @param \Orthos\Bundle\FinanceiroBundle\Entity\LancamentosCategoria $sq_lancamentos_categoria
     */
    public function setSqLancamentosCategoria ($sq_lancamentos_categoria)
    {
        $this->sq_lancamentos_categoria = $sq_lancamentos_categoria;
    }

    /**
     * @return \Orthos\Bundle\FinanceiroBundle\Entity\LancamentosCategoria
     */
    public function getSqLancamentosCategoria ()
    {
        return $this->sq_lancamentos_categoria;
    }
}
