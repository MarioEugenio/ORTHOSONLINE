<?php

namespace Core\OrthosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TabelaPreco
 *
 * @ORM\Table(name="tb_tabela_preco")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class TabelaPreco extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_tabela_preco", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_tabela_preco;

    /**
     * @var string
     *
     * @ORM\Column(name="no_procedimento", type="string", length=100)
     */
    private $no_procedimento;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_procedimento", type="string", length=255, nullable=true)
     */
    private $ds_procedimento;

    /**
     * @var float
     *
     * @ORM\Column(name="vl_total", type="decimal", precision=12, scale=2)
     */
    private $vl_total;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_plano", type="string", length=255, nullable=true)
     */
    private $ds_plano;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_fixo", type="boolean", nullable=true)
     */
    private $fl_fixo;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_tipo", type="string", length=1, nullable=true)
     */
    private $fl_tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_kit", type="boolean", nullable=true)
     */
    private $fl_kit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;

    /**
     * @var  \Core\OrthosBundle\Entity\Especialidade
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Especialidade")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_especialidade", referencedColumnName="sq_especialidade")
     * })
     */
    private $sq_especialidade;


    /**
     * Get sq_tabela_preco
     *
     * @return integer 
     */
    public function getSqTabelaPreco()
    {
        return $this->sq_tabela_preco;
    }

    /**
     * Set no_procedimento
     *
     * @param string $noProcedimento
     * @return TabelaPreco
     */
    public function setNoProcedimento($noProcedimento)
    {
        $this->no_procedimento = $noProcedimento;
    
        return $this;
    }

    /**
     * Get no_procedimento
     *
     * @return string 
     */
    public function getNoProcedimento()
    {
        return $this->no_procedimento;
    }

    /**
     * Set ds_procedimento
     *
     * @param string $dsProcedimento
     * @return TabelaPreco
     */
    public function setDsProcedimento($dsProcedimento)
    {
        $this->ds_procedimento = $dsProcedimento;
    
        return $this;
    }

    /**
     * Get ds_procedimento
     *
     * @return string 
     */
    public function getDsProcedimento()
    {
        return $this->ds_procedimento;
    }

    /**
     * Set vl_total
     *
     * @param float $vlTotal
     * @return TabelaPreco
     */
    public function setVlTotal($vlTotal)
    {
        $this->vl_total = str_replace(',','', $vlTotal);
    
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
     * Set ds_plano
     *
     * @param string $dsPlano
     * @return TabelaPreco
     */
    public function setDsPlano($dsPlano)
    {
        $this->ds_plano = $dsPlano;
    
        return $this;
    }

    /**
     * Get ds_plano
     *
     * @return string 
     */
    public function getDsPlano()
    {
        return $this->ds_plano;
    }

    /**
     * Set fl_fixo
     *
     * @param string $flFixo
     * @return TabelaPreco
     */
    public function setFlFixo($flFixo)
    {
        $this->fl_fixo = $flFixo;
    
        return $this;
    }

    /**
     * Get fl_fixo
     *
     * @return string 
     */
    public function getFlFixo()
    {
        return $this->fl_fixo;
    }

    /**
     * Set fl_tipo
     *
     * @param string $flTipo
     * @return TabelaPreco
     */
    public function setFlTipo($flTipo)
    {
        $this->fl_tipo = $flTipo;
    
        return $this;
    }

    /**
     * Get fl_tipo
     *
     * @return string 
     */
    public function getFlTipo()
    {
        return $this->fl_tipo;
    }

    /**
     * Set fl_kit
     *
     * @param string $flKit
     * @return TabelaPreco
     */
    public function setFlKit($flKit)
    {
        $this->fl_kit = $flKit;
    
        return $this;
    }

    /**
     * Get fl_kit
     *
     * @return string 
     */
    public function getFlKit()
    {
        return $this->fl_kit;
    }

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return TabelaPreco
     */
    public function setFlAtivo($flAtivo)
    {
        $this->fl_ativo = $flAtivo;
    
        return $this;
    }

    /**
     * Get fl_ativo
     *
     * @return boolean 
     */
    public function getFlAtivo()
    {
        return $this->fl_ativo;
    }

    /**
     * Set sq_especialidade
     *
     * @param \Core\OrthosBundle\Entity\Especialidade $sqEspecialidade
     * @return TabelaPreco
     */
    public function setSqEspecialidade(\Core\OrthosBundle\Entity\Especialidade $sqEspecialidade)
    {
        $this->sq_especialidade = $sqEspecialidade;
    
        return $this;
    }

    /**
     * Get sq_especialidade
     *
     * @return \Core\OrthosBundle\Entity\Especialidade
     */
    public function getSqEspecialidade()
    {
        return $this->sq_especialidade;
    }

    /**
     * @param int $sq_tabela_preco
     */
    public function setSqTabelaPreco ($sq_tabela_preco)
    {
        $this->sq_tabela_preco = $sq_tabela_preco;
    }
}
