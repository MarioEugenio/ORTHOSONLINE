<?php

namespace Core\OrthosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Perfil
 *
 * @ORM\Table(name="tb_perfil")
 * @ORM\Entity
 */
class Perfil extends \abstraction\entity\AbstractEntity implements \Symfony\Component\Security\Core\Role\RoleInterface
{
    /**
     * @var integer $sq_perfil
     *
     * @ORM\Column(name="sq_perfil", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_perfil;

    /**
     * @var string $no_perfil
     *
     * @ORM\Column(name="no_perfil", type="string", length=255)
     */
    private $no_perfil;

    /**
     * @var boolean $fl_ativo
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;

    /**
     * @ManyToMany(targetEntity="\Core\OrthosBundle\Entity\Menu")
     * @JoinTable(name="tb_menu_perfil",
     *      joinColumns={@JoinColumn(name="sq_perfil", referencedColumnName="sq_perfil")},
     *      inverseJoinColumns={@JoinColumn(name="sq_menu", referencedColumnName="sq_menu")}
     *      )
     */
    private $menus;

    public function __construct(Array $data=NULL) {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
        parent::__construct($data);
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole ()
    {
        return $this->no_perfil;
    }

    /**
     * @param int $sq_perfil
     */
    public function setSqPerfil ($sq_perfil)
    {
        $this->sq_perfil = $sq_perfil;
    }

    /**
     * @return int
     */
    public function getSqPerfil ()
    {
        return $this->sq_perfil;
    }

    /**
     * @param string $no_perfil
     */
    public function setNoPerfil ($no_perfil)
    {
        $this->no_perfil = $no_perfil;
    }

    /**
     * @return string
     */
    public function getNoPerfil ()
    {
        return $this->no_perfil;
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

    public function getMenus ()
    {
        return $this->menus;
    }

}
