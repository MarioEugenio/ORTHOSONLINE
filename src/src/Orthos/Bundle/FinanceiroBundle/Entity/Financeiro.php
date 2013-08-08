<?php

namespace Orthos\Bundle\FinanceiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Financeiro
 *
 * @ORM\Table(name="tb_financeiro")
 * @ORM\Entity
 */
class Financeiro extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_financeiro", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_financeiro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="date")
     */
    private $dt_cadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_observacao", type="string", length=400, nullable=true)
     */
    private $tx_observacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_parcelas", type="integer")
     */
    private $nu_parcelas;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_tipo_pagamento", type="string", length=1, nullable=true)
     */
    private $fl_tipo_pagamento;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_documento", type="string", length=50, nullable=true)
     */
    private $nu_documento;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_total", type="decimal", precision=12, scale=2)
     */
    private $vl_total;

    /**
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_usuario", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_usuario;

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
     * @var  \Core\OrthosBundle\Entity\Especialidade
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Especialidade", cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_especialidade", referencedColumnName="sq_especialidade")
     * })
     */
    private $sq_especialidade;


    /**
     * Get sq_financeiro
     *
     * @return integer 
     */
    public function getSqFinanceiro()
    {
        return $this->sq_financeiro;
    }

    /**
     * Set dt_cadastro
     *
     * @param \DateTime $dtCadastro
     * @return Financeiro
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
     * Set tx_observacao
     *
     * @param string $txObservacao
     * @return Financeiro
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
     * Set nu_parcelas
     *
     * @param integer $nuParcelas
     * @return Financeiro
     */
    public function setNuParcelas($nuParcelas)
    {
        $this->nu_parcelas = $nuParcelas;
    
        return $this;
    }

    /**
     * Get nu_parcelas
     *
     * @return integer 
     */
    public function getNuParcelas()
    {
        return $this->nu_parcelas;
    }

    /**
     * Set vl_total
     *
     * @param float $vlTotal
     * @return Financeiro
     */
    public function setVlTotal($vlTotal)
    {
        $this->vl_total = $vlTotal;
    
        return $this;
    }

    /**
     * Get vl_total
     *
     * @return float 
     */
    public function getVlTotal()
    {
        return $this->vl_total;
    }

    /**
     * Set sq_usuario
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuario
     * @return Financeiro
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
     * Set sq_paciente
     *
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Paciente $sqPaciente
     * @return Financeiro
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
     * @param string $nu_documento
     */
    public function setNuDocumento ($nu_documento)
    {
        $this->nu_documento = $nu_documento;
    }

    /**
     * @return string
     */
    public function getNuDocumento ()
    {
        return $this->nu_documento;
    }

    /**
     * @param \Core\OrthosBundle\Entity\Especialidade $sq_especialidade
     */
    public function setSqEspecialidade ($sq_especialidade)
    {
        $this->sq_especialidade = $sq_especialidade;
    }

    /**
     * @return \Core\OrthosBundle\Entity\Especialidade
     */
    public function getSqEspecialidade ()
    {
        return $this->sq_especialidade;
    }
}
