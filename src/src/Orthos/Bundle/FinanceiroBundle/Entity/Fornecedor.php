<?php

namespace Orthos\Bundle\FinanceiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fornecedor
 *
 * @ORM\Table(name="tb_fornecedor")
 * @ORM\Entity
 */
class Fornecedor extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_fornecedor", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_fornecedor;

    /**
     * @var string
     *
     * @ORM\Column(name="no_fornecedor", type="string", length=255)
     */
    private $no_fornecedor;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_cnpj", type="string", length=20, nullable=true)
     */
    private $nu_cnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="no_razao_social", type="string", length=255)
     */
    private $no_razao_social;

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
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;


    /**
     * Get sq_fornecedor
     *
     * @return integer 
     */
    public function getSqFornecedor()
    {
        return $this->sq_fornecedor;
    }

    /**
     * Set no_fornecedor
     *
     * @param string $noFornecedor
     * @return Fornecedor
     */
    public function setNoFornecedor($noFornecedor)
    {
        $this->no_fornecedor = $noFornecedor;
    
        return $this;
    }

    /**
     * Get no_fornecedor
     *
     * @return string 
     */
    public function getNoFornecedor()
    {
        return $this->no_fornecedor;
    }

    /**
     * Set nu_cnpj
     *
     * @param string $nuCnpj
     * @return Fornecedor
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
     * Set no_razao_social
     *
     * @param string $noRazaoSocial
     * @return Fornecedor
     */
    public function setNoRazaoSocial($noRazaoSocial)
    {
        $this->no_razao_social = $noRazaoSocial;
    
        return $this;
    }

    /**
     * Get no_razao_social
     *
     * @return string 
     */
    public function getNoRazaoSocial()
    {
        return $this->no_razao_social;
    }

    /**
     * Set nu_telefone
     *
     * @param string $nuTelefone
     * @return Fornecedor
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
     * @return Fornecedor
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
     * @param string $fl_ativo
     */
    public function setFlAtivo ($fl_ativo)
    {
        $this->fl_ativo = $fl_ativo;
    }

    /**
     * @return string
     */
    public function getFlAtivo ()
    {
        return $this->fl_ativo;
    }
}
