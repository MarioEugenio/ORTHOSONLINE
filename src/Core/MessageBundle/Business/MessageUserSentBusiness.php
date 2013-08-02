<?php

namespace Core\MessageBundle\Business;

use abstraction\business\AbstractBusiness;
use abstraction\business\exception\ExceptionBusiness;
use Core\MessageBundle\Entity\MessageUserSent;

class MessageUserSentBusiness extends AbstractBusiness
{
    protected $model = '\Core\MessageBundle\Model\MessageUserSentModel';

    /**
     * Salva a mensagem
     *
     * @param \Core\MessageBundle\Entity\Message $entityMessage
     */
    public function save (MessageUserSent $entityMessageUserSent)
    {
        $this->_validateSave($entityMessageUserSent);
        $this->getModel()->save($entityMessageUserSent);
    }

    /**
     * valida o save de MessageUserSent
     *
     * @param \Core\MessageBundle\Entity\MessageUserSent $entityMessageUserSent
     */
    public function _validateSave(MessageUserSent $entityMessageUserSent){
        if (!$entityMessageUserSent->getDtCreate()) {
            $this->addMessage($this->getTranslator('message.validate.date'));
        }

        if (!count($entityMessageUserSent->getMessage())) {
            $this->addMessage($this->getTranslator('message.validate.message'));
        }

        if (!count($entityMessageUserSent->getUser())) {
            $this->addMessage($this->getTranslator('message.validate.users'));
        }

        $this->exceptionMessages();


    }

    /**
     * Remove MessageUserSent
     *
     * @param \Core\MessageBundle\Entity\MessageUserSent $messageUserSent
     */
    public function removeMessageUserSent(MessageUserSent $messageUserSent) {
        $messageUserSent->setFlRead(FALSE);
        $this->save($messageUserSent);
    }

    /**
     * Remove MessageUserSent
     *
     * @param \Core\MessageBundle\Entity\MessageUserSent $messageUserSent
     */
    public function removeMessageLogicalUserSent(MessageUserSent $messageUserSent) {
        $messageUserSent->setFlActive(FALSE);
        $this->save($messageUserSent);
    }

    public function getReplysFromMessage(\Core\MessageBundle\Entity\Message $entityMessage, \Core\UserBundle\Entity\Users $entityUser){
        $model = $this->getModel();
        $result = $model->getReplysFromMessage($entityMessage, $entityUser);
        return $result;
    }
}
