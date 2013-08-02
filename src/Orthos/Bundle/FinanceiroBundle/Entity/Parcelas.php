<?php

namespace Orthos\Bundle\FinanceiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parcelas
 *
 * @ORM\Table(name="tb_parcelas")
 * @ORM\Entity
 */
class Parcelas extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_parcelas", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_parcelas;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_parcela", type="integer")
     */
    private $nu_parcela;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_pagamento", type="date", nullable=true)
     */
    private $dt_pagamento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_vencimento", type="date", nullable=true)
     */
    private $dt_vencimento;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_parcela", type="decimal", precision=12, scale=2)
     */
    private $vl_parcela;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_desconto", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $vl_desconto;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_pagamento", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $vl_pagamento;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_juros", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $vl_juros;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_mora", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $vl_mora;

    /**
     * @var  \Orthos\Bundle\FinanceiroBundle\Entity\Financeiro
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\FinanceiroBundle\Entity\Financeiro")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_financeiro", referencedColumnName="sq_financeiro")
     * })
     */
    private $sq_financeiro;

    /**
     * @var  \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\FinanceiroBundle\Entity\Parcelas")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_parcela_negociada", referencedColumnName="sq_parcelas")
     * })
     */
    private $sq_parcela_negociada;

    /**
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_usuario_baixa", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_usuario_baixa;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_status", type="string", length=1)
     */
    private $fl_status;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_tipo_pagamento", type="string", length=2)
     */
    private $fl_tipo_pagamento;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_cheque_devolvido", type="boolean", nullable=true)
     */
    private $fl_cheque_devolvido;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_documento", type="string", length=255, nullable=true)
     */
    private $tx_documento;

    private $dt_inicio;

    private $dt_fim;

    private $is_atraso;

    /**
     * Get sq_parcelas
     *
     * @return integer 
     */
    public function getSqParcelas()
    {
        return $this->sq_parcelas;
    }

    /**
     * Set nu_parcela
     *
     * @param integer $nuParcela
     * @return Parcelas
     */
    public function setNuParcela($nuParcela)
    {
        $this->nu_parcela = $nuParcela;
    
        return $this;
    }

    /**
     * Get nu_parcela
     *
     * @return integer 
     */
    public function getNuParcela()
    {
        return $this->nu_parcela;
    }

    /**
     * Set dt_pagamento
     *
     * @param \DateTime $dtPagamento
     * @return Parcelas
     */
    public function setDtPagamento($dtPagamento)
    {
        $this->dt_pagamento = $dtPagamento;
    
        return $this;
    }

    /**
     * Get dt_pagamento
     *
     * @return \DateTime 
     */
    public function getDtPagamento()
    {
        return $this->dt_pagamento;
    }

    /**
     * Set dt_vencimento
     *
     * @param \DateTime $dtVencimento
     * @return Parcelas
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
     * Set vl_parcela
     *
     * @param float $vlParcela
     * @return Parcelas
     */
    public function setVlParcela($vlParcela)
    {
        $this->vl_parcela = $vlParcela;
    
        return $this;
    }

    /**
     * Get vl_parcela
     *
     * @return float 
     */
    public function getVlParcela()
    {
        return $this->vl_parcela;
    }

    /**
     * Set vl_desconto
     *
     * @param float $vlDesconto
     * @return Parcelas
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
     * Set vl_pagamento
     *
     * @param float $vlPagamento
     * @return Parcelas
     */
    public function setVlPagamento($vlPagamento)
    {
        $this->vl_pagamento = $vlPagamento;
    
        return $this;
    }

    /**
     * Get vl_pagamento
     *
     * @return float 
     */
    public function getVlPagamento()
    {
        return $this->vl_pagamento;
    }

    /**
     * Set vl_juros
     *
     * @param float $vlJuros
     * @return Parcelas
     */
    public function setVlJuros($vlJuros)
    {
        $this->vl_juros = $vlJuros;
    
        return $this;
    }

    /**
     * Get vl_juros
     *
     * @return float 
     */
    public function getVlJuros()
    {
        return $this->vl_juros;
    }

    /**
     * Set vl_mora
     *
     * @param float $vlMora
     * @return Parcelas
     */
    public function setVlMora($vlMora)
    {
        $this->vl_mora = $vlMora;
    
        return $this;
    }

    /**
     * Get vl_mora
     *
     * @return float 
     */
    public function getVlMora()
    {
        return $this->vl_mora;
    }

    /**
     * Set sq_financeiro
     *
     * @param \Orthos\Bundle\FinanceiroBundle\Entity\Financeiro $sqFinanceiro
     * @return Parcelas
     */
    public function setSqFinanceiro(\Orthos\Bundle\FinanceiroBundle\Entity\Financeiro $sqFinanceiro)
    {
        $this->sq_financeiro = $sqFinanceiro;
    
        return $this;
    }

    /**
     * Get sq_financeiro
     *
     * @return \Orthos\Bundle\FinanceiroBundle\Entity\Financeiro
     */
    public function getSqFinanceiro()
    {
        return $this->sq_financeiro;
    }

    /**
     * Set sq_usuario_baixa
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuarioBaixa
     * @return Parcelas
     */
    public function setSqUsuarioBaixa($sqUsuarioBaixa)
    {
        $this->sq_usuario_baixa = $sqUsuarioBaixa;
    
        return $this;
    }

    /**
     * Get sq_usuario_baixa
     *
     * @return \Core\OrthosBundle\Entity\Usuario
     */
    public function getSqUsuarioBaixa()
    {
        return $this->sq_usuario_baixa;
    }

    /**
     * Set fl_status
     *
     * @param string $flStatus
     * @return Parcelas
     */
    public function setFlStatus($flStatus)
    {
        $this->fl_status = $flStatus;
    
        return $this;
    }

    /**
     * Get fl_status
     *
     * @return string 
     */
    public function getFlStatus()
    {
        return $this->fl_status;
    }

    /**
     * Set tx_documento
     *
     * @param string $txDocumento
     * @return Parcelas
     */
    public function setTxDocumento($txDocumento)
    {
        $this->tx_documento = $txDocumento;
    
        return $this;
    }

    /**
     * Get tx_documento
     *
     * @return string 
     */
    public function getTxDocumento()
    {
        return $this->tx_documento;
    }

    /**
     * @param \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas $sq_parcela_negociada
     */
    public function setSqParcelaNegociada ($sq_parcela_negociada)
    {
        $this->sq_parcela_negociada = $sq_parcela_negociada;
    }

    /**
     * @return \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas
     */
    public function getSqParcelaNegociada ()
    {
        return $this->sq_parcela_negociada;
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

    public function setIsAtraso ($is_atraso)
    {
        $this->is_atraso = $is_atraso;
    }

    public function getIsAtraso ()
    {
        return $this->is_atraso;
    }

    /**
     * @param string $fl_tipo_pagamento
     */
    public function setFlTipoPagamento ($fl_tipo_pagamento)
    {
        $this->fl_tipo_pagamento = $fl_tipo_pagamento;
    }

    /**
     * @return string
     */
    public function getFlTipoPagamento ()
    {
        return $this->fl_tipo_pagamento;
    }

    /**
     * @param string $fl_cheque_devolvido
     */
    public function setFlChequeDevolvido ($fl_cheque_devolvido)
    {
        $this->fl_cheque_devolvido = $fl_cheque_devolvido;
    }

    /**
     * @return string
     */
    public function getFlChequeDevolvido ()
    {
        return $this->fl_cheque_devolvido;
    }
}
