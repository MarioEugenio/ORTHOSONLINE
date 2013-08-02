<?php
namespace Core\MessageBundle\Controller;

use \abstraction\controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use abstraction\business\exception\ExceptionBusiness;
use Core\UserBundle\Entity\Users;
use Core\MessageBundle\Entity\Message;
use Core\MessageBundle\Entity\MessageUserSent;
use Core\MessageBundle\Business\MessageBusiness;
use abstraction\node\Node;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{

    protected $business = '\Core\MessageBundle\Business\MessageBusiness';

    /**
     * @Route("/index", name="message_index", options={"expose"=true})
     * @Template()
     */
    public function indexAction ()
    {

        $result = array();


        return $result;
    }

    /**
     * Tela de mensagens
     *
     * @Route("/listMessage", name="message_list_inbox", options={"expose"=true})
     * @Template()
     */
    public function messageAction ()
    {
        return $this->returnSecurityView();
    }

    /**
     * @Route("/inbox", name="message_inbox", options={"expose"=true})
     */
    public function inboxAction ()
    {
        /** @var \Core\MessageBundle\Business\MessageBusiness $business  */
        $business = $this->getBusiness();
        return $this->responseJson($business->getInboxMessage());
    }

    /**
     * @Route("/sent", name="message_sent", options={"expose"=true})
     */
    public function sentAction ()
    {
        /** @var \Core\MessageBundle\Business\MessageBusiness $business  */
        $business = $this->getBusiness();
        return $this->responseJson($business->getSentMessage());
    }

    /**
     * notificação para cadastro de participante de comunidade
     *
     * @param \Core\MessageBundle\Entity\MessageUserSent $entity
     * @param \Core\MessageBundle\Entity\Message $message
     * @return void
     * @internal param \Core\WorkspaceBundle\Entity\WorkspaceParticipant $entityWorkspace
     */
    private function _notifyMessage (MessageUserSent $entity, Message $message)
    {
            /** @var $notificationBusiness \Core\NotificationBundle\Business\NotificationBusiness */
            $notificationBusiness = $this->callService('CoreNotification.NotificationBusiness');

            if ($entity->getFlBox() == 'I') {
                $user = $entity->getUser();

                $notificationBusiness->addNotificationMethod(
                    $user,
                    array(
                        'message' => 'message.sent.notification',
                        'paramsMessage' => array('noUser'=>'getNoUser')
                    ),
                    array(
                        'link' => 'message_index',
                        'paramsLink' => NULL
                    ),
                    $message
                );
            }
    }

    /**
     * @Route("/savenew", name="message_new", options={"expose"=true})
     */
    public function saveNewAction ()
    {
        try {
            $data = $this->getRequestJson();

            $entityMessageReply = NULL;
            $entityMessageOrigin = NULL;
            /** @var \Core\MessageBundle\Business\MessageBusiness $bussinessMessage  */
            $businessMessage = $this->get('CoreMessage.MessageBusiness');
            if (isset($data['co_message'])) {
                /** @var Message $entityMessageReply  */
                $entityMessageReply = $businessMessage->find($data['co_message']);
            }

            if (isset($data['co_message_origin'])) {
                /** @var Message $entityMessageOrigin  */
                $entityMessageOrigin = $businessMessage->find($data['co_message_origin']);
                if ($entityMessageOrigin) {
                    $data['ds_subject'] = "Re: " . $entityMessageOrigin->getDsSubject();
                }
            } else {
                if ($entityMessageReply) {
                    $data['ds_subject'] = "Re: " . $entityMessageReply->getDsSubject();
                }
            }

            $entityMessage = new Message();

            if(isset($data['ds_message'])){
                $entityMessage->setDsMessage($data['ds_message']);
            }
            if(isset($data['ds_subject'])){
                $entityMessage->setDsSubject($data['ds_subject']);
            }
            $entityMessage->setFlActive(TRUE);
            $entityMessage->setDtSent(new \DateTime());
            $entityMessage->setDtCreate(new \DateTime());
            $entityMessage->setUser($this->getAuthenticate());

            foreach ($data['users_sent'] as $value) {
                /** @var $businessUser \Core\UserBundle\Business\UserBusiness */
                $businessUser = $this->get('CoreUser.UserBusiness');
                /** @var $entityUser Users */
                $entityUser = $businessUser->find($value['id']);

                if (!$entityUser) {
                    continue;
                }

                $entityMessageUserSent = new MessageUserSent();
                $entityMessageUserSent->setDtCreate(new \DateTime());
                $entityMessageUserSent->setFlActive(TRUE);
                $entityMessageUserSent->setFlBox('I');
                $entityMessageUserSent->setFlRead(FALSE);
                $entityMessageUserSent->setUser($entityUser);
                $entityMessageUserSent->setMessage($entityMessage);
                $entityMessageUserSent->setMessageOrigin(($entityMessageOrigin ? $entityMessageOrigin : $entityMessage));
                if (isset($entityMessageReply)) {
                    $entityMessageUserSent->setMessageReply($entityMessageReply);
                }

                Node::getInstance()->addDataCollectors($entityUser->getCoUser());

                $entityMessage->getMessageUserSent()->add($entityMessageUserSent);

                $this->_notifyMessage($entityMessageUserSent,$entityMessage);
            }

            if ($entityMessageUserSent->getMessageReply() != NULL) {
                $entityMessageUserSentToMe = clone $entityMessageUserSent;
                $entityMessageUserSentToMe->setUser($this->getAuthenticate());
                $entityMessageUserSentToMe->setFlBox('R');
                $entityMessageUserSentToMe->setDtRead(new \DateTime());
                $entityMessageUserSentToMe->setFlRead(TRUE);
                $entityMessage->getMessageUserSent()->add($entityMessageUserSentToMe);
            }

            $this->getBusiness()->save($entityMessage);

            Node::getInstance()->notify();

            return $this->responseMessage($this->getTranslator('message.sent_success'), TRUE);

        } catch (ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }

    }

    /**
     * @Route("/sendmessage", name="message_send_message", options={"expose"=true})
     * @Template()
     */
    public function sendMessageAction ()
    {
        $for = $this->getRequest()->get('for');
        return $this->returnSecurityView(array('for' => $for));
    }

    /**
     * @Route("/show/{coMessage}", name="message_show", options={"expose"=true})
     * @Template()
     */
    public function showAction ($coMessage)
    {
        $entity = $this->getBusiness()->find($coMessage);
        $result = $this->getBusiness()->getMessage($entity);
        return $this->responseJson($result);
    }

    /**
     * @Route("/search", name="message_search", options={"expose"=true})
     */
    public function searchAction ()
    {
        $data = $this->getRequestJson();
        $result = $this->getBusiness()->getSearchMessage($data);
        return $this->responseJson($result);
    }

    /**
     * @Route("/removeMessage/{box}", name="message_remove", options={"expose"=true})
     */
    public function removeMessageAction ($box)
    {
        try {
            $data = $this->getRequestJson();

            /** @var $business \Core\MessageBundle\Business\MessageBusiness */
            $business = $this->getBusiness();

            foreach ($data as $key => $value) {
                if ($value) {
                    /** @var $entity Message */
                    $entity = $business->find($key);
                    $business->removeLogicalMessage($entity, $box);
                }
            }
            return $this->responseMessage('message.remove.success', TRUE);
        } catch (ExceptionBusiness $exc) {
            return $this->responseMessage('message.remove.fail', FALSE);
        }
    }

    /**
     * @Route("/lastMessagesWithoutRead", name="CoreMessage_Message_last_messages", options={"expose"=true})
     */
    public function lastMessagesWithoutReadAction ()
    {
        return $this->responseJson($this->getBusiness()->getLastMessagesWithoutRead());
    }
    /**
     * @Route("/test", name="message_index_test", options={"expose"=true})
     * @Template()
     */
    public function countMessageAction(){
        $this->getBusiness()->getCountMessage();
        return $this->responseMessage('cheguei', TRUE);
    }

    /**
     * @Route("/getTotalUnreadMessage", name="CoreMessage_Message_total_unread", options={"expose"=true})
     */
    public function getTotalUnreadMessageAction(){
        /** @var $messageBusiness \Core\MessageBundle\Business\MessageBusiness */
        $messageBusiness = $this->get('CoreMessage.MessageBusiness');
        $countMessage = $messageBusiness->getLastMessagesWithoutRead();
        return $this->responseJson(array('total' => count($countMessage)));
    }

}

