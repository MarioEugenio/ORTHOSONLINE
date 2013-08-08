<?php

namespace Core\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Core\MessageBundle\Entity\MessageUserSent
 *
 * @ORM\Table(name="tb_message_user_sent")
 * @ORM\Entity
 */
class MessageUserSent extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer $co_message_user_sent
     *
     * @ORM\Column(name="co_message_user_sent", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $co_message_user_sent;

    /**
     * @var boolean $fl_read
     *
     * @ORM\Column(name="fl_read", type="boolean")
     */
    private $fl_read;

    /**
     * @var datetime $dt_read
     *
     * @ORM\Column(name="dt_read", type="datetime", nullable=true)
     */
    private $dt_read;

    /**
     * @var datetime $dt_create
     *
     * @ORM\Column(name="dt_create", type="datetime")
     */
    private $dt_create;

    /**
     * Usuário que recebeu a mensagem
     *
     * @var \Core\UserBundle\Entity\Users
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario", inversedBy="messages_user_sent")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="co_user", referencedColumnName="sq_usuario", nullable=false)
     * })
     */
    private $user;

    /**
     * Código da mensagem
     * @var \Core\MessageBundle\Entity\Message
     * @ORM\ManyToOne(targetEntity="\Core\MessageBundle\Entity\Message", inversedBy="message_user_sent")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="co_message", referencedColumnName="co_message")
     * })
     */
    private $message;

    /**
     * Código da mensagem respondida
     * @var \Core\MessageBundle\Entity\Message
     * @ORM\ManyToOne(targetEntity="\Core\MessageBundle\Entity\Message", inversedBy="message_reply")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="co_message_reply", referencedColumnName="co_message", nullable=true)
     * })
     */
    private $message_reply;

    /**
     * @var \Core\MessageBundle\Entity\Message
     * @ORM\ManyToOne(targetEntity="\Core\MessageBundle\Entity\Message", inversedBy="message_origin")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="co_message_origin", referencedColumnName="co_message")
     * })
     */
    private $message_origin;

    /**
     * @var boolean $fl_active
     * @ORM\Column(name="fl_active", type="boolean", nullable=true)
     */
    private $fl_active;

    /**
     * I - Inbox, T - Trash,  S - Sent
     * @var boolean $fl_box
     * @ORM\Column(name="fl_box", type="string", length=1, nullable=true)
     */
    private $fl_box;

    public function __construct (Array $data = NULL)
    {
        parent::__construct($data);
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fl_active = TRUE;
    }

    /**
     * Get co_message_user_sent
     *
     * @return integer 
     */
    public function getCoMessageUserSent()
    {
        return $this->co_message_user_sent;
    }

    /**
     * Set fl_read
     *
     * @param boolean $flRead
     * @return MessageUserSent
     */
    public function setFlRead($flRead)
    {
        $this->fl_read = $flRead;
        return $this;
    }

    /**
     * Get fl_read
     *
     * @return boolean 
     */
    public function getFlRead()
    {
        return $this->fl_read;
    }

    /**
     * Set dt_read
     *
     * @param datetime $dtRead
     * @return MessageUserSent
     */
    public function setDtRead($dtRead)
    {
        $this->dt_read = $dtRead;
        return $this;
    }

    /**
     * Get dt_read
     *
     * @return datetime 
     */
    public function getDtRead()
    {
        return $this->dt_read;
    }

    /**
     * Set dt_create
     *
     * @param datetime $dtCreate
     * @return MessageUserSent
     */
    public function setDtCreate($dtCreate)
    {
        $this->dt_create = $dtCreate;
        return $this;
    }

    /**
     * Get dt_create
     *
     * @return datetime 
     */
    public function getDtCreate()
    {
        return $this->dt_create;
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
     * @param \Core\MessageBundle\Entity\Message
     */
    public function setMessage (\Core\MessageBundle\Entity\Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Core\MessageBundle\Entity\Message
     */
    public function getMessage ()
    {
        return $this->message;
    }

    /**
     * @param \Core\MessageBundle\Entity\Message $message_origin
     */
    public function setMessageOrigin ($message_origin)
    {
        $this->message_origin = $message_origin;
    }

    /**
     * @return \Core\MessageBundle\Entity\Message
     */
    public function getMessageOrigin ()
    {
        return $this->message_origin;
    }

    /**
     * @param \Core\MessageBundle\Entity\Message
     */
    public function setMessageReply (\Core\MessageBundle\Entity\Message $message)
    {
        $this->message_reply = $message;
    }

    /**
     * @return \Core\MessageBundle\Entity\Message
     */
    public function getMessageReply ()
    {
        return $this->message_reply;
    }

    /**
     * Set fl_active
     *
     * @param boolean $flActive
     *
     * @return MessageUserSent
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
     * @param boolean $fl_box
     */
    public function setFlBox ($fl_box)
    {
        $this->fl_box = $fl_box;
    }

    /**
     * @return boolean
     */
    public function getFlBox ()
    {
        return $this->fl_box;
    }
}