<?php

namespace Core\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Core\MessageBundle\Entity\Message
 *
 * @ORM\Table(name="tb_message")
 * @ORM\Entity
 */
class Message extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer $co_message
     *
     * @ORM\Column(name="co_message", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $co_message;

    /**
     * @var string $ds_subject
     *
     * @ORM\Column(name="ds_subject", type="string", length=300, nullable=true)
     */
    private $ds_subject;

    /**
     * @var text $ds_message
     *
     * @ORM\Column(name="ds_message", type="text", nullable=true)
     */
    private $ds_message;

    /**
     * @var boolean $fl_active
     *
     * @ORM\Column(name="fl_active", type="boolean", nullable=false)
     */
    private $fl_active;

    /**
     * @var datetime $dt_create
     *
     * @ORM\Column(name="dt_create", type="datetime")
     */
    private $dt_create;

    /**
     * @var datetime $dt_sent
     *
     * @ORM\Column(name="dt_sent", type="datetime", nullable=true)
     */
    private $dt_sent;

    /**
     * @var \Core\UserBundle\Entity\Users
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario", inversedBy="messages")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="co_user", referencedColumnName="sq_usuario", nullable=false)
     * })
     */
    private $user;

    /**
     * Coleção de componentes selecionados para o workspace
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="\Core\MessageBundle\Entity\MessageUserSent", mappedBy="message",cascade={"persist"})
     */
    private $message_user_sent;

    /**
     * Coleção de componentes selecionados para o workspace
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="\Core\MessageBundle\Entity\MessageUserSent", mappedBy="message_reply")
     */
    private $message_reply;

    private $search;

    public function __construct (Array $data = NULL)
    {
        parent::__construct($data);
        $this->setDtCreate(new \DateTime('now'));
        $this->setFlActive(TRUE);
        $this->message_user_sent = new ArrayCollection();
        $this->message_reply = new ArrayCollection();
    }

    /**
     * @param \Core\UserBundle\Entity\Users
     */
    public function setUser (\Core\UserBundle\Entity\Users $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Core\UserBundle\Entity\Users
     */
    public function getUser ()
    {
        return $this->user;
    }

    /**
     * Get co_message
     *
     * @return integer
     */
    public function getCoMessage ()
    {
        return $this->co_message;
    }

    /**
     * Set ds_subject
     *
     * @param string $dsSubject
     *
     * @return Message
     */
    public function setDsSubject ($dsSubject)
    {
        $this->ds_subject = $dsSubject;
        return $this;
    }

    /**
     * Get ds_subject
     *
     * @return string
     */
    public function getDsSubject ()
    {
        return $this->ds_subject;
    }

    /**
     * Set ds_message
     *
     * @param text $dsMessage
     *
     * @return Message
     */
    public function setDsMessage ($dsMessage)
    {
        $this->ds_message = $dsMessage;
        return $this;
    }

    /**
     * Get ds_message
     *
     * @return text
     */
    public function getDsMessage ()
    {
        return $this->ds_message;
    }

    /**
     * Set fl_active
     *
     * @param boolean $flActive
     *
     * @return ForumCategory
     */
    public function setFlActive ($flActive)
    {
        $this->fl_active = $flActive;
        return $this;
    }

    /**
     * Get fl_active
     *
     * @return boolean
     */
    public function getFlActive ()
    {
        return $this->fl_active;
    }

    /**
     * Set dt_create
     *
     * @param datetime $dtCreate
     *
     * @return Message
     */
    public function setDtCreate ($dtCreate)
    {
        $this->dt_create = $dtCreate;
        return $this;
    }

    /**
     * Get dt_create
     *
     * @return datetime
     */
    public function getDtCreate ()
    {
        return $this->dt_create;
    }

    /**
     * Set dt_sent
     *
     * @param datetime $dtSent
     *
     * @return Message
     */
    public function setDtSent ($dtSent)
    {
        $this->dt_sent = $dtSent;
        return $this;
    }

    /**
     * Get dt_sent
     *
     * @return datetime
     */
    public function getDtSent ()
    {
        return $this->dt_sent;
    }

    /**
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $values
     */
    public function setMessageUserSent (ArrayCollection $values)
    {
        $this->message_user_sent = $values;
    }

    /**
     * Retorna os metadados
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMessageUserSent ()
    {
        return $this->message_user_sent;
    }

    public function getSearch ()
    {
        return $this->search;
    }

    public function setSearch ($search)
    {
        $this->search = $search;
    }
}