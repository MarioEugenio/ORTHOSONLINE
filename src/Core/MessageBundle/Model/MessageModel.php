<?php
namespace Core\MessageBundle\Model;

use abstraction\model\AbstractModel;
use Core\MessageBundle\Entity\Message;
use Core\MessageBundle\Entity\MessageUserSent;
use Core\OrthosBundle\Entity\Usuario;
use Core\MessageBundle\ConstMessage;

/**
 * Modelo das mensagens
 */
class MessageModel extends AbstractModel
{
    protected $repository = "CoreMessageBundle:Message";

    /**
     * @param \Core\OrthosBundle\Entity\Usuario $user
     * @param \Core\MessageBundle\Entity\Message $message
     * @return array|\Doctrine\ORM\EntityRepository
     */
    public function getMessages (Usuario $user = NULL, Message $message = NULL)
    {
        $dql = "SELECT
                u.no_usuario AS my_name,
                uso.sq_usuario AS user_origin,
                m.ds_subject, m.ds_message, m.co_message, mus.fl_read, mus.dt_create, mus.fl_box,
                muso.co_message AS co_message_origin,
                    ulast.sq_usuario AS co_user_senter, ulast.no_usuario AS user_senter, ulast.no_image_profile,
                mot.ds_subject AS ds_subject_origin,
                mo.co_message AS dono,
                m.dt_sent
            FROM Core\OrthosBundle\Entity\Usuario u
                JOIN u.messages_user_sent mus
                JOIN mus.message m
                JOIN mus.message_origin muso
                JOIN muso.user uso
                JOIN m.user ulast
                LEFT JOIN mus.message_origin mot
                LEFT JOIN mus.message_origin mo WITH mo.user = mus.user
            WHERE
                mus.fl_active = TRUE

                ";

        if ($user) {
            $dql .= " AND mus.user = :coUser";
            $arParams['coUser'] = $user->getSqUsuario();
        }

        if ($message) {
            $dql .= " AND muso.co_message = :coMessage";
            $arParams['coMessage'] = $message->getCoMessage();
        }

        $dql .= " ORDER BY m.co_message";

        return $this->select($dql, $arParams);
    }

    /**
     * @param \Core\MessageBundle\Entity\Message $message
     * @param \Core\OrthosBundle\Entity\Usuario $user
     * @return array|\Doctrine\ORM\EntityRepository
     */
    public function getMessageAndReply (Message $message, Usuario $user)
    {
        $dql = "SELECT
                    m.co_message, m.ds_message, m.ds_subject, m.dt_sent, mus.fl_read,
                    mo.co_message AS message_origin,
                    uo.sq_usuario AS co_user_origin,
                    ufriend.no_usuario AS no_user, ufriend.sq_usuario as co_user, ufriend.no_image_profile
                FROM Core\MessageBundle\Entity\Message m
                    JOIN m.message_user_sent mus
                    JOIN mus.message_origin mo
                    JOIN mus.message mfriend
                    JOIN mfriend.user ufriend
                    JOIN mo.user uo
                    JOIN mus.user u
                WHERE mus.message_origin = :coMessage AND u.sq_usuario = :coUser ORDER BY m.dt_sent";

        $params['coMessage'] = $message->getCoMessage();
        $params['coUser'] = $user->getSqUsuario();
        return $this->select($dql, $params);
    }

    /**
     * @param \Core\OrthosBundle\Entity\Usuario $user
     * @return array|\Doctrine\ORM\EntityRepository
     */
    public function getSentMessages (Usuario $user)
    {
        $dql = "SELECT
                u.no_usuario AS no_user, u.sq_usuario AS co_user, m.ds_subject, m.ds_message, m.co_message, m.dt_sent
            FROM Core\MessageBundle\Entity\Message m
              JOIN m.message_user_sent mus
              JOIN mus.user u
            WHERE m.fl_active = TRUE AND m.user = :coUser
            ORDER BY m.co_message DESC
        ";


        $arParams['coUser'] = $user->getSqUsuario();

        return $this->select($dql, $arParams);
    }

    /**
     * @param $data
     * @param \Core\OrthosBundle\Entity\Usuario $entityUser
     * @return array|\Doctrine\ORM\EntityRepository
     */
    public function getSearchMessages ($data, Usuario $entityUser)
    {
        $dql = "SELECT
                u.no_usuario AS my_name,
                m.ds_subject, m.ds_message, m.co_message, mus.fl_read, mus.dt_create,
                muso.co_message AS co_message_origin,
                ulast.no_usuario AS user_senter, ulast.no_image_profile,
                mot.ds_subject AS ds_subject_origin,
                mo.co_message AS dono,
                m.dt_sent
            FROM Core\OrthosBundle\Entity\Usuario u
                JOIN u.messages_user_sent mus
                JOIN mus.message m
                JOIN mus.message_origin muso
                JOIN m.user ulast
                LEFT JOIN mus.message_origin mot
                LEFT JOIN mus.message_origin mo WITH mo.user = mus.user
                WHERE
                     m.fl_active = true
                     AND mus.fl_active = true
                     AND (mus.user = :coUser OR m.user = :coUser)
        ";

        $params['coUser'] = $entityUser->getSqUsuario();

        if (!empty($data['generic'])) {
            $dql .= "AND (
                            LOWER(ulast.no_usuario) LIKE :search_string
                            OR LOWER(u.no_usuario) LIKE :search_string
                            OR LOWER(m.ds_message) LIKE :search_string
                            OR LOWER(m.ds_subject) LIKE :search_string
                        )";
            $params['search_string'] = '%' . strtolower($data['generic']) . '%';
        } else {
            if (!empty($data['from'])) {
                $dql .= ' AND LOWER(u.no_usuario) LIKE :from';
                $params['from'] = '%' . strtolower($data['from']) . '%';
            }

            if (!empty($data['to'])) {
                $dql .= ' AND LOWER(ulast.no_usuario) LIKE :to';
                $params['to'] = '%' . strtolower($data['to']) . '%';
            }

            if (!empty($data['subject'])) {
                $dql .= ' AND LOWER(m.ds_subject) LIKE :subject';
                $params['subject'] = '%' . strtolower($data['subject']) . '%';
            }

            if (!empty($data['message'])) {
                $dql .= ' AND LOWER(m.ds_message) LIKE :message';
                $params['message'] = '%' . strtolower($data['message']) . '%';
            }

            if (!empty($data['dt_start']) && !empty($data['dt_end'])) {
                $dql .= ' AND m.dt_sent BETWEEN :dt_start AND :dt_end';
                $params['dt_start'] = $data['dt_start']->format('Y-m-d 00:00:00');
                $params['dt_end'] = $data['dt_end']->format('Y-m-d 23:59:59');
            }
        }

        $dql .= " ORDER BY m.co_message";

        return $this->select($dql, $params);
    }

    /**
     * @param $coMessage
     * @param \Core\OrthosBundle\Entity\Usuario $authenticateUser
     * @return array|\Doctrine\ORM\EntityRepository
     */
    public function getUsersByCoMessage($coMessage, $co_user){

        $dql = "SELECT u.sq_usuario AS id, u.no_usuario AS name, m.co_message, mo.co_message AS co_message_origin
        FROM \Core\MessageBundle\Entity\MessageUserSent mus
            INNER JOIN mus.user u
            INNER JOIN mus.message m
            INNER JOIN mus.message_origin mo
            WHERE mus.message = :coMessage";
            //--AND u.co_user <> :userSenter";

        $arParams['coMessage'] = $coMessage;
        //$arParams['userSenter'] = $co_user;
        return $this->select($dql, $arParams);
    }

    /**
     * Método que retorna a lista das ultimas mensagens não lidas de um usuário
     *
     * @param \Core\OrthosBundle\Entity\Usuario $user
     *
     * @internal param null $limit
     *
     * @return array|\Doctrine\ORM\EntityRepository
     */
    public function getLastMessagesWithoutRead (Usuario $user)
    {
        $dql = "SELECT
                u.no_usuario AS my_name,
                m.ds_subject, m.ds_message, m.co_message, mus.fl_read, mus.dt_create,
                muso.co_message AS co_message_origin,
                ulast.no_usuario AS user_senter, ulast.no_image_profile,
                mot.ds_subject AS ds_subject_origin,
                mo.co_message AS dono,
                m.dt_sent
            FROM Core\OrthosBundle\Entity\Usuario u
                JOIN u.messages_user_sent mus
                JOIN mus.message m
                JOIN mus.message_origin muso
                JOIN m.user ulast
                LEFT JOIN mus.message_origin mot
                LEFT JOIN mus.message_origin mo WITH mo.user = mus.user
            WHERE
                mus.fl_active = TRUE
                AND mus.fl_read = TRUE
                AND mus.user = :coUser
                ";

            $arParams['coUser'] = $user->getSqUsuario();

        $dql .= " ORDER BY m.co_message";

        return $this->select($dql, $arParams);
    }
}
