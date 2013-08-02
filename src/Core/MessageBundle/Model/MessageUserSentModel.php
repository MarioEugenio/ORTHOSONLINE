<?php
namespace Core\MessageBundle\Model;

use abstraction\model\AbstractModel;

use Core\MessageBundle\Entity\Message;

class MessageUserSentModel extends AbstractModel
{
    protected $repository = "CoreMessageBundle:MessageUserSent";

    public function getReplysFromMessage(Message $entity, \Core\OrthosBundle\Entity\Usuario $entityUser){
        /**
         * SELECT
        mus.*
        FROM
        tb_message m
        JOIN tb_message_user_sent mus ON m.co_message = mus.co_message
        WHERE
        mus.co_user = 5601
        AND (m.co_message = 250
        OR m.co_message_reply = 250);
         */

        $dql = '

            SELECT
                mus
            FROM
                Core\MessageBundle\Entity\MessageUserSent mus
                    JOIN mus.message m
            WHERE
                mus.user = :user
                AND (m.co_message = :co_message OR m.message_reply = :message)
        ';

        $params['user'] = $entityUser;
        $params['message'] = $entity;
        $params['co_message'] = $entity->getCoMessage();

        return $this->select($dql, $params);
    }
}
