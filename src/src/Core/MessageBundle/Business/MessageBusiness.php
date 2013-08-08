<?php

namespace Core\MessageBundle\Business;

use abstraction\business\AbstractBusiness;
use abstraction\business\exception\ExceptionBusiness;
use Core\MessageBundle\Entity\Message;
use Core\MessageBundle\Entity\MessageUserSent;
use Core\MessageBundle\Business\MessageUserSentBusiness;
use Core\MessageBundle\ConstMessage;
use Core\MessageBundle\Model\MessageModel;

/**
 * Classe de negócios da mensagem
 */
class MessageBusiness extends AbstractBusiness
{
    protected $model = '\Core\MessageBundle\Model\MessageModel';

    /**
     * Lista das mensagens da caixa de entrada
     */
    public function getInboxMessage ($coUser = NULL)
    {
        if ($coUser) {
            /** @var $userBusiness \Core\UserBundle\Business\UserBusiness */
            $userBusiness = $this->callService('CoreUser.UserBusiness');
            $entityUser = $userBusiness->find($coUser);

        } else {
            $entityUser = $this->getAuthenticate();
        }

        $messages = $this->getModel()->getMessages($entityUser);

        $coUserAuth = $this->getAuthenticate()->getSqUsuario();

        $arMessages = array();

        foreach ($messages as $message) {
            $arMessages[$message["co_message_origin"]]['co_message_origin'] = $message["co_message_origin"];
            $arMessages[$message["co_message_origin"]]['subject'] = $message["ds_subject_origin"];
            $arMessages[$message["co_message_origin"]]['fl_read'] = $message["fl_read"];

            if (!isset($arMessages[$message["co_message_origin"]]['sub_message'])) {
                $arMessages[$message["co_message_origin"]]['sub_message'] = array();
            }

            if ($message['fl_box'] == 'I') {
                $arMessages[$message["co_message_origin"]]['sub_message'][$message["co_message"]] = $message["user_senter"];
            }

            $arMessages[$message["co_message_origin"]]['co_user_sub'][$message["co_message"]] = $message["co_user_senter"];

            $arSubMessagesNoUser = $arMessages[$message["co_message_origin"]]['sub_message'];
            $arSubMessages = $arMessages[$message["co_message_origin"]]['co_user_sub'];

            $arMessages[$message["co_message_origin"]]['count_messages'] = ($coUserAuth == $message['user_origin'] ? count($arSubMessages) + 1 : count($arSubMessages));
            $arMessages[$message["co_message_origin"]]['users'] = array_pop($arSubMessagesNoUser);
            $arMessages[$message["co_message_origin"]]['dt_sent'] = $message['dt_sent']->format('c');
            $arMessages[$message["co_message_origin"]]['dt_sent_order'] = $message['dt_create']->getTimestamp();
        }

        return array_values($arMessages);
    }

    /**
     *
     * @return array
     */
    public function getSentMessage ()
    {
        $entityUser = $this->getAuthenticate();

        /** @var $model MessageModel */
        $model = $this->getModel();
        $messages = $model->getSentMessages($entityUser);

        $arMessages = array();

        foreach ($messages as $message) {
            $users_name = NULL;

            if ($this->getAuthenticate()->getSqUsuario() != $message['co_user']) {
                $arUsers[$message["co_message"]][] = $message["no_user"];
                $users_name = implode(',', $arUsers[$message["co_message"]]);
            }

            $arMessages[$message["co_message"]]['co_message'] = $message["co_message"];
            $arMessages[$message["co_message"]]['subject'] = $message["ds_subject"];
            $arMessages[$message["co_message"]]['message'] = $message["ds_message"];

            // tratando na view caso $users_name venha vazio exibir o nome do usuario logado
            $arMessages[$message["co_message"]]['users'] = $users_name;

            $arMessages[$message["co_message"]]['dt_sent'] = $message['dt_sent']->format('c');
            $arMessages[$message["co_message"]]['dt_sent_order'] = $message['dt_sent']->getTimestamp();

        }

        krsort($arMessages);
        return array_values($arMessages);
    }

    /**
     * @param $data
     * @return array
     */
    public function getSearchMessage ($data)
    {
        $entityUser = $this->getAuthenticate();
        $messages = $this->getModel()->getSearchMessages($data, $entityUser);

        $arMessages = array();

        foreach ($messages as $message) {
            $arMessages[$message["co_message_origin"]]['co_message_origin'] = $message["co_message_origin"];
            $arMessages[$message["co_message_origin"]]['subject'] = $message["ds_subject_origin"];
            $arMessages[$message["co_message_origin"]]['message'] = $message["ds_message"];
            $arMessages[$message["co_message_origin"]]['sub_message'][$message["co_message"]] = $message["user_senter"];

            $arSubMessages = $arMessages[$message["co_message_origin"]]['sub_message'];

            $arMessages[$message["co_message_origin"]]['receivers'][$message["co_message"]] = implode(',', $arSubMessages);

            $arMessages[$message["co_message_origin"]]['count_messages'] = count($arSubMessages);
            $arMessages[$message["co_message_origin"]]['users'] = array_pop($arSubMessages);
            $arMessages[$message["co_message_origin"]]['dt_sent'] = $message['dt_sent']->format('c');
        }

        krsort($arMessages);
        return array_values($arMessages);
    }

    /**
     * Recupera mensagem selecionada e as respostas
     *
     * @param \Core\MessageBundle\Entity\Message $entityMessage
     *
     * @return array
     */
    public function getMessage (Message $entityMessage)
    {
        $messages = $this->getModel()->getMessageAndReply($entityMessage, $this->getAuthenticate());
        $arMessages = array();

        foreach ($messages as $message) {
            $this->setReadMessage($entityMessage, $message);

            $arMessages[$message["co_message"]] = $message;
            $arMessages[$message["co_message"]]['co_user_logged'] = $this->getAuthenticate()->getSqUsuario();
            $arMessages[$message["co_message"]]["users"] = $this->_usersSentList($entityMessage, $message);
            $arMessages[$message["co_message"]]['no_image_profile'] = $this->getUserProfilePictureBySource($message['no_image_profile']);
            $arMessages[$message["co_message"]]['dt_sent'] = $message['dt_sent']->format('c');
        }

        if (!array_key_exists($entityMessage->getCoMessage(), $arMessages)) {
            $listUsers = $this->getModel()->getUsersByCoMessage($entityMessage->getCoMessage(), $entityMessage->getUser()->getSqUsuario());
            $this->_addCoUserLogged($listUsers);

            $arMensagemOriginal['co_user_logged'] = $this->getAuthenticate()->getSqUsuario();
            $arMensagemOriginal['co_message'] = $entityMessage->getCoMessage();
            $arMensagemOriginal['ds_message'] = nl2br($entityMessage->getDsMessage());
            $arMensagemOriginal['ds_subject'] = $entityMessage->getDsSubject();
            $arMensagemOriginal["users"] = $listUsers;
            $arMensagemOriginal['dt_sent'] = $entityMessage->getDtSent()->format('c');
            $arMensagemOriginal['message_origin'] = $entityMessage->getCoMessage();
            $arMensagemOriginal['co_user_origin'] = $entityMessage->getUser()->getSqUsuario();
            $arMensagemOriginal['no_user'] = $entityMessage->getUser()->getNoUsuario();
            $arMensagemOriginal['co_user'] = $entityMessage->getUser()->getNoUsuario();
            $arMensagemOriginal['no_image_profile'] = $this->getUserProfilePictureBySource($entityMessage->getUser()->getNoImageProfile());

            array_unshift($arMessages, $arMensagemOriginal);
        }
        return array_values($arMessages);
    }

    /**
     * Lista de usuários e mensagens
     *
     * @param \Core\MessageBundle\Entity\Message $entityMessage
     * @param $message
     *
     * @return array
     */
    private function _usersSentList (Message $entityMessage, $message)
    {
        $userOriginal = FALSE;

        /*if ($message['co_user_origin'] == $this->getAuthenticate()->getCoUser()) {
            $userOriginal = new \stdClass();
            $userOriginal->id = $message['co_user'];
            $userOriginal->name = $message['no_user'];
            $userOriginal->co_user_logged = $this->getAuthenticate()->getCoUser();
            $userOriginal->co_message = $entityMessage->getCoMessage();
            $userOriginal->co_message_origin = $entityMessage->getCoMessage();

        }*/

        $listUsers = $this->getModel()->getUsersByCoMessage($message["co_message"], $message['co_user']);
        if (is_array($listUsers)) {

            $this->_addCoUserLogged($listUsers);

            if ($userOriginal) {
                array_unshift($listUsers, $userOriginal);
            }
        }

        return $listUsers;
    }

    /**
     * @param $listUsers
     */
    private function _addCoUserLogged (&$listUsers)
    {
        foreach ($listUsers as $key => $user) {
            $listUsers[$key]['co_user_logged'] = $this->getAuthenticate()->getSqUsuario();
        }
    }

    /**
     * @param \Core\MessageBundle\Entity\Message $entityMessage
     * @param $message
     */
    public function setReadMessage (Message $entityMessage, $message)
    {

        /** @var $businessMessageUserSent MessageUserSentBusiness */
        $businessMessageUserSent = $this->callService('CoreMessage.MessageUserSentBusiness');

        if (!$message['fl_read']) {
            $entityMessageUserSent = $businessMessageUserSent->findBy(TRUE, array(
                'message_origin' => $entityMessage,
                'user' => $this->getAuthenticate()
            ));
            /** @var $valueMUS MessageUserSent */
            foreach ($entityMessageUserSent as $valueMUS) {
                $valueMUS->setFlRead(TRUE);
                $valueMUS->setDtRead(new \DateTime());
                $businessMessageUserSent->save($valueMUS);
            }
        }
        
    }

    /**
     * @param \Core\MessageBundle\Entity\Message $entityMessage
     *
     * @throws \abstraction\business\exception\ExceptionBusiness|\Exception
     * @return void
     */
    public function save (Message $entityMessage)
    {
        $this->_validate($entityMessage);
        $this->exceptionMessages();

        $this->beginTransaction();
        try {
            /** @var $modelMessage \Core\MessageBundle\Model\MessageModel */
            $modelMessage = $this->getModel();
            $modelMessage->save($entityMessage);
            $this->commit();
            
        } catch (ExceptionBusiness $exc) {
            $this->rollback();
            throw $exc;
        }
    }

    /**
     * Valida a obrigatoriedade dos campos
     *
     * @param \Core\MessageBundle\Entity\Message $entityMessage
     */
    public function _validate (Message $entityMessage)
    {
        if (!$entityMessage->getDsSubject()) {
            $this->addMessage($this->getTranslator('message.validate.subject'));
        }

        if (!$entityMessage->getDsMessage()) {
            $this->addMessage($this->getTranslator('message.validate.empty_message'));
        }

        $arrEntityMessageUserSent = $entityMessage->getMessageUserSent();
        if (!$arrEntityMessageUserSent[0]->getUser()) {
            $this->addMessage($this->getTranslator('message.validate.users'));
        }

        if (strlen($entityMessage->getDsSubject()) > 300) {
            $this->addMessage($this->getTranslator('message.validate.subject_limit'));
        }
    }

    /**
     * @param \Core\MessageBundle\Entity\Message $entity
     * @param string $box
     */
    public function removeLogicalMessage (Message $entity, $box = 'inbox')
    {
        if ($box == 'inbox') {

            /** @var $businessMessageUserSent MessageUserSentBusiness */
            $businessMessageUserSent = $this->callService('CoreMessage.MessageUserSentBusiness');
            $entityMessageUserSent = $businessMessageUserSent->findBy(TRUE, array(
                'message_origin' => $entity,
                'user' => $this->getAuthenticate()

            ));

            /** @var $value MessageUserSent */
            foreach ($entityMessageUserSent as $value) {
                $value->setFlActive(FALSE);
                $businessMessageUserSent->save($value);
            }
        } else {
            $entity->setFlActive(FALSE);
            $this->getModel()->save($entity);
        }
    }

    /**
     * Método que retorna as ultimas mensagens não lidas
     * @param null $coUser
     * @return array
     */
    public function getLastMessagesWithoutRead ($coUser = NULL)
    {
        $arrResult = array();
        $messages = $this->getInboxMessage($coUser);
        foreach ($messages as $value) {
            if (!$value['fl_read']) {
                $aux['co_message_origin'] = $value['co_message_origin'];
                $aux['users'] = $value['users'];
                $aux['subject'] = $value['subject'];
                $aux['dt_sent'] = $value['dt_sent'];
                $aux['fl_read'] = $value['fl_read'];
                $aux['dt_sent_order'] = $value['dt_sent_order'];
                $arrResult[] = $aux;
            }
        }

        return $arrResult;
    }
}