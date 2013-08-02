<?php

namespace Core\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dasboard
 *
 * @ORM\Table(name="tb_dashboard")
 * @ORM\Entity
 */
class Dashboard extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_dashboard", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_dashboard;

    /**
     * @var string
     *
     * @ORM\Column(name="no_dashboard", type="string", length=100)
     */
    private $no_dashboard;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_dashboard", type="string", length=255)
     */
    private $ds_dashboard;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_posicao", type="string", length=1)
     */
    private $fl_posicao;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_endereco", type="string", length=255)
     */
    private $tx_endereco;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;


    /**
     * Get sq_dashboard
     *
     * @return integer 
     */
    public function getSqDashboard()
    {
        return $this->sq_dashboard;
    }

    /**
     * Set no_dashboard
     *
     * @param string $noDashboard
     * @return Dasboard
     */
    public function setNoDashboard($noDashboard)
    {
        $this->no_dashboard = $noDashboard;
    
        return $this;
    }

    /**
     * Get no_dashboard
     *
     * @return string 
     */
    public function getNoDashboard()
    {
        return $this->no_dashboard;
    }

    /**
     * Set ds_dashboard
     *
     * @param string $dsDashboard
     * @return Dasboard
     */
    public function setDsDashboard($dsDashboard)
    {
        $this->ds_dashboard = $dsDashboard;
    
        return $this;
    }

    /**
     * Get ds_dashboard
     *
     * @return string 
     */
    public function getDsDashboard()
    {
        return $this->ds_dashboard;
    }

    /**
     * Set tx_endereco
     *
     * @param string $txEndereco
     * @return Dasboard
     */
    public function setTxEndereco($txEndereco)
    {
        $this->tx_endereco = $txEndereco;
    
        return $this;
    }

    /**
     * Get tx_endereco
     *
     * @return string 
     */
    public function getTxEndereco()
    {
        return $this->tx_endereco;
    }

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return Dasboard
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
     * @param string $fl_posicao
     */
    public function setFlPosicao ($fl_posicao)
    {
        $this->fl_posicao = $fl_posicao;
    }

    /**
     * @return string
     */
    public function getFlPosicao ()
    {
        return $this->fl_posicao;
    }
}
