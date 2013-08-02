<?php

namespace Core\OrthosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Serializable;

/**
 * Usuario
 *
 * @ORM\Table(name="tb_usuario")
 * @ORM\Entity
 */
class Usuario extends \abstraction\entity\AbstractEntity implements UserInterface, \Serializable
{
    /**
     * @var integer $sq_usuario
     *
     * @ORM\Column(name="sq_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_usuario;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $ds_salt;

    /**
     * @var string $no_usuario
     *
     * @ORM\Column(name="no_usuario", type="string", length=255)
     */
    private $no_usuario;

    /**
     * @var string $ds_email
     *
     * @ORM\Column(name="ds_email", type="string", length=255)
     */
    private $ds_email;

    /**
     * @var string $tx_senha
     *
     * @ORM\Column(name="tx_senha", type="string", length=100)
     */
    private $tx_senha;

    /**
     * @var boolean $fl_ativo
     *
     * @ORM\Column(name="fl_ativo", type="boolean")
     */
    private $fl_ativo;

    /**
     * @var boolean $fl_atendente
     *
     * @ORM\Column(name="fl_atendente", type="boolean", nullable=true)
     */
    private $fl_atendente;

    /**
     * @var boolean $fl_medico
     *
     * @ORM\Column(name="fl_medico", type="boolean", nullable=true)
     */
    private $fl_medico;

    /**
     * @var string $no_image_profile
     *
     * @ORM\Column(name="no_image_profile", type="string", length=255, nullable=true)
     */
    private $no_image_profile;

    /**
     * Coleção de messages enviadas por usuario
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="\Core\MessageBundle\Entity\MessageUserSent", mappedBy="user")
     */
    private $messages_user_sent;

    /**
     * @ManyToMany(targetEntity="\Core\OrthosBundle\Entity\Perfil")
     * @JoinTable(name="tb_usuario_perfil",
     *      joinColumns={@JoinColumn(name="sq_usuario", referencedColumnName="sq_usuario")},
     *      inverseJoinColumns={@JoinColumn(name="sq_perfil", referencedColumnName="sq_perfil")}
     *      )
     */
    private $perfis;

    /**
     * @ManyToMany(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Clinica")
     * @JoinTable(name="tb_usuario_clinica",
     *      joinColumns={@JoinColumn(name="sq_usuario", referencedColumnName="sq_usuario")},
     *      inverseJoinColumns={@JoinColumn(name="sq_clinica", referencedColumnName="sq_clinica")}
     *      )
     */
    private $clinicas;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Clinica")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_clinica", referencedColumnName="sq_clinica")
     * })
     */
    private $sq_clinica;

    public function __construct(Array $data=NULL) {
        $this->perfis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clinicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ds_salt = md5(uniqid(NULL, TRUE));

        parent::__construct($data);
    }

    /**
     * @param string $no_usuario
     */
    public function setNoUsuario ($no_usuario)
    {
        $this->no_usuario = $no_usuario;
    }

    /**
     * @return string
     */
    public function getNoUsuario ()
    {
        return $this->no_usuario;
    }

    /**
     * @param int $sqUsuario
     */
    public function setSqUsuario ($sqUsuario)
    {
        $this->sq_usuario = $sqUsuario;
    }

    /**
     * @return int
     */
    public function getSqUsuario ()
    {
        return $this->sq_usuario;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles ()
    {
        return $this->getPerfis();
    }

    /**
     * Returns the password used to authenticate the user.
     * @return string The password
     */
    public function getPassword ()
    {
        return $this->getTxSenha();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * @return string The salt
     */
    public function getSalt ()
    {
        return $this->ds_salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername ()
    {
        return $this->no_usuario;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials ()
    {
        $this->no_usuario = NULL;
        $this->ds_salt = NULL;
    }

    public function addPerfis ($perfis)
    {
        $this->perfis[] = $perfis;
    }

    public function getPerfis ()
    {
        return $this->perfis;
    }

    public function getClinicas ()
    {
        return $this->clinicas;
    }

    /**
     * @param string $ds_email
     */
    public function setDsEmail ($ds_email)
    {
        $this->ds_email = $ds_email;
    }

    /**
     * @return string
     */
    public function getDsEmail ()
    {
        return $this->ds_email;
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

    /**
     * @param string $tx_senha
     */
    public function setTxSenha ($tx_senha)
    {
        $this->tx_senha = $tx_senha;
    }

    /**
     * @return string
     */
    public function getTxSenha ()
    {
        return $this->tx_senha;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Clinica $sq_clinica
     */
    public function setSqClinica (\Orthos\Bundle\ClinicaBundle\Entity\Clinica $sq_clinica)
    {
        $this->sq_clinica = $sq_clinica;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     */
    public function getSqClinica ()
    {
        return $this->sq_clinica;
    }

    /**
     * @param \ArrayCollection $messages_user_sent
     */
    public function setMessagesUserSent ($messages_user_sent)
    {
        $this->messages_user_sent = $messages_user_sent;
    }

    /**
     * @return \ArrayCollection
     */
    public function getMessagesUserSent ()
    {
        return $this->messages_user_sent;
    }

    /**
     * @param string $no_image_profile
     */
    public function setNoImageProfile ($no_image_profile)
    {
        $this->no_image_profile = $no_image_profile;
    }

    /**
     * @return string
     */
    public function getNoImageProfile ()
    {
        return $this->no_image_profile;
    }
    /**
     * @param boolean $fl_atendente
     */public function setFlAtendente ($fl_atendente)
    {
        $this->fl_atendente = $fl_atendente;
    }/**
     * @return boolean
     */public function getFlAtendente ()
    {
        return $this->fl_atendente;
    }

    public function __toString () {
        return $this->no_usuario;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize ()
    {
        return serialize($this->getSqUsuario());
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     *
     * @return mixed the original value unserialized.
     */
    public function unserialize ($data)
    {
        $this->sq_usuario = unserialize($data);
    }

    /**
     * Returns whether or not the given user is equivalent to *this* user.
     *
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     *
     * @return Boolean
     */
    function equals (UserInterface $user)
    {
        return $this->no_usuario === $user->getUsername();
    }

    public function setDsSalt ($ds_salt)
    {
        $this->ds_salt = $ds_salt;
    }

    public function getDsSalt ()
    {
        return $this->ds_salt;
    }

    /**
     * @param boolean $fl_medico
     */
    public function setFlMedico ($fl_medico)
    {
        $this->fl_medico = $fl_medico;
    }

    /**
     * @return boolean
     */
    public function getFlMedico ()
    {
        return $this->fl_medico;
    }
}
