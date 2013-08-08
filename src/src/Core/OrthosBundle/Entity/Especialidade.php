<?php

namespace Core\OrthosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Especialidade
 *
 * @ORM\Table(name="tb_especialidade")
 * @ORM\Entity
 */
class Especialidade extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_especialidade", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_especialidade;

    /**
     * @var string
     *
     * @ORM\Column(name="no_especialidade", type="string", length=100)
     */
    private $no_especialidade;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_especialidade", type="string", length=255)
     */
    private $ds_especialidade;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;

    /**
     * @OneToMany(targetEntity="\Core\OrthosBundle\Entity\TabelaPreco", mappedBy="sq_especialidade", cascade={"all"})
     */
    private $tabela_preco;

    public function __construct() {
        $this->tabela_preco = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get sq_especialidade
     *
     * @return integer 
     */
    public function getSqEspecialidade()
    {
        return $this->sq_especialidade;
    }

    /**
     * Set no_especialidade
     *
     * @param string $noEspecialidade
     * @return Especialidade
     */
    public function setNoEspecialidade($noEspecialidade)
    {
        $this->no_especialidade = $noEspecialidade;
    
        return $this;
    }

    /**
     * Get no_especialidade
     *
     * @return string 
     */
    public function getNoEspecialidade()
    {
        return $this->no_especialidade;
    }

    /**
     * Set ds_especialidade
     *
     * @param string $dsEspecialidade
     * @return Especialidade
     */
    public function setDsEspecialidade($dsEspecialidade)
    {
        $this->ds_especialidade = $dsEspecialidade;
    
        return $this;
    }

    /**
     * Get ds_especialidade
     *
     * @return string 
     */
    public function getDsEspecialidade()
    {
        return $this->ds_especialidade;
    }

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return Especialidade
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

    public function setTabelaPreco (TabelaPreco $tabela_preco)
    {
        $this->tabela_preco = $tabela_preco;
    }

    public function getTabelaPreco ()
    {
        return $this->tabela_preco;
    }
}
