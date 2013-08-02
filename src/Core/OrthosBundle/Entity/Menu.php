<?php

namespace Core\OrthosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="tb_menu")
 * @ORM\Entity
 */
class Menu extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_menu", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_menu;

    /**
     * @var string
     *
     * @ORM\Column(name="no_menu", type="string", length=50)
     */
    private $no_menu;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_uri", type="string", length=255)
     */
    private $ds_uri;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;

    /**
     * @var  \Core\OrthosBundle\Entity\Menu
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Menu")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_menu_filho", referencedColumnName="sq_menu")
     * })
     */
    private $sq_menu_filho;


    /**
     * Get sq_menu
     *
     * @return integer 
     */
    public function getSqMenu()
    {
        return $this->sq_menu;
    }

    /**
     * Set no_menu
     *
     * @param string $noMenu
     * @return Menu
     */
    public function setNoMenu($noMenu)
    {
        $this->no_menu = $noMenu;
    
        return $this;
    }

    /**
     * Get no_menu
     *
     * @return string 
     */
    public function getNoMenu()
    {
        return $this->no_menu;
    }

    /**
     * Set ds_uri
     *
     * @param string $dsUri
     * @return Menu
     */
    public function setDsUri($dsUri)
    {
        $this->ds_uri = $dsUri;
    
        return $this;
    }

    /**
     * Get ds_uri
     *
     * @return string 
     */
    public function getDsUri()
    {
        return $this->ds_uri;
    }

    /**
     * Set fl_ativo
     *
     * @param boolean $flAtivo
     * @return Menu
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
     * @param \Core\OrthosBundle\Entity\Menu $sq_menu_filho
     */
    public function setSqMenuFilho ($sq_menu_filho)
    {
        $this->sq_menu_filho = $sq_menu_filho;
    }

    /**
     * @return \Core\OrthosBundle\Entity\Menu
     */
    public function getSqMenuFilho ()
    {
        return $this->sq_menu_filho;
    }

}
