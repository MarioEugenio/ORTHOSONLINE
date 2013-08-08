<?php

/**
 * Classe Abstrata para Business
 * @package abstraction\business
 * @name AbstractBusiness
 * @author Mário Eugênio <mario.oliveira@xys.com.br>
 * @version 0.0.1
 */

namespace abstraction\business;

use Doctrine\ORM\Mapping\Entity;
use abstraction\business\exception\ExceptionBusiness;
use abstraction\model\AbstractModel;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

use \Core\LayoutsBundle\ConstLayouts;
use \Core\UserBundle\ConstUser;

abstract class AbstractBusiness
{

    /**
     * Objeto de Model
     * @var ObjectModel
     */
    protected $model;

    /**
     * Instância Container
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Array de mensagens
     * @var array
     */
    private $result = array();

    /**
     * @var Entity
     */
    protected $entityManager;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $_connection;

    public function __construct ($container = NULL, $entityManager = NULL)
    {
        $this->container = $container;

        $environment = NULL;

        if ($this->container && $this->container->has('kernel')) {
            $environment = $this->container->get('kernel')->getEnvironment();
        }

        $this->entityManager = ($environment == 'test' ? $environment : $entityManager);
    }

    public function setContainer ($container)
    {
        $this->container = $container;
    }

    /**
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function setConnection (\Doctrine\DBAL\Connection $connection)
    {
        $this->_connection = $connection;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection ()
    {
        if ($this->_connection === NULL) {
            $this->_connection = $this->getModel()->getEntityManager()->getConnection();
        }

        return $this->_connection;
    }

    /**
     * Inicia transação
     */
    public function beginTransaction ()
    {
        $this->getConnection()->beginTransaction();
    }

    /**
     * efetiva transação
     */
    public function commit ()
    {
        $this->getConnection()->commit();
    }

    /**
     * reverte transação
     */
    public function rollback ()
    {
        $this->getConnection()->rollback();
    }

    /**
     * Retorna a model de sua estrutura
     * @return \abstraction\model\AbstractModel
     * @throws \abstraction\model\exception\ExceptionModel
     */
    public function getModel ()
    {
        if (is_null($this->model)) {
            $function = new \ReflectionClass(\get_class($this));
            $this->model = preg_replace("/Business/", "Model", $function->getName());
        }

        if (is_string($this->model)) {
            $this->model = new $this->model($this->container->get('doctrine'), $this->entityManager, $this->container);
        }

        if (!$this->model instanceof AbstractModel) {
            throw new \abstraction\model\exception\ExceptionModel('Deve ser um objeto model');
        }

        return $this->model;
    }

    /**
     * Seta model para business
     *
     * @param string $model
     */
    public function setModel ($model)
    {
        $this->model = $model;
    }

    /**
     * retorna container
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer ()
    {
        return $this->container;
    }

    /**
     * Delegator para o model
     *
     * @param string $method
     * @param args $args
     *
     * @throws exception\ExceptionBusiness
     * @return mixed
     */
    public function __call ($method, $args)
    {
        $model = $this->getModel();

        if (!method_exists($model, $method)) {
            throw new exception\ExceptionBusiness(sprintf('Método %s inexistente nesta model %s!', $method, get_class($model)));
        }

        return call_user_func_array(array($model, $method), (array) $args);
    }

    /**
     * Método para invocar serviço instânciado para o bundle
     *
     * @param $service
     *
     * @return object
     */
    public function callService ($service)
    {
        $container = $this->container->get($service);
        if (in_array('setContainer', get_class_methods(get_class($container)))) {
            $container->setContainer($this->container);
        }

        return $container;
    }

    /**
     * Cosulta simples para o repositório selecionado
     *
     * @param boolean $isObject
     *
     * @return array|object
     */
    public function findAll ($isObject = TRUE)
    {
        $model = $this->getModel();
        return $model->findAll($isObject);
    }

    /**
     * Método que retorna 1 registro
     * @return array|object
     */
    public function findOne ()
    {
        $model = $this->getModel();
        return current($model->findBy(TRUE, array(), NULL, 1));
    }

    /**
     * Consulta por chave para o repositório selecionado
     *
     * @param integer $key
     * @param boolean $isObject
     *
     * @return \abstraction\entity\AbstractEntity
     */
    public function find ($key, $isObject = TRUE)
    {
        $model = $this->getModel();
        return $model->find($key, $isObject);
    }


    public function delete ($id) {
        $model = $this->getModel();
        return $model->delete($id);
    }

    /**
     * pesquisa por parâmetro
     *
     * @param boolean $isObject
     * @param array $array
     * @param string $orderBy
     * @param string $limit
     * @param string $offset
     *
     * @return array
     */
    public function findBy ($isObject = TRUE, Array $array, $orderBy = NULL, $limit = NULL, $offset = NULL)
    {
        $model = $this->getModel();
        return $model->findBy($isObject, $array, $orderBy, $limit, $offset);
    }

    /**
     * Gera rash string|array com data de expiração
     *
     * @param string|array $paramExtra é possível definir um array de dados a serem encodados no hash ou uma string de dado
     * @param integer $dayExpire
     *
     * @return string
     */
    public function generateHash ($paramExtra = NULL, $dayExpire = 7)
    {
        $timeNow = time();

        $expire = $timeNow + (60 * 60 * (24 * $dayExpire));
        $dateExp = strftime("%c", $expire);

        if (!is_null($paramExtra)) {
            if (is_array($paramExtra)) {
                $arData = $paramExtra;
            } else {
                $arData[] = $paramExtra;
            }
        }

        $arData['expired'] = $dateExp;

        foreach ($arData as $key => $value) {
            $arKeyValPair[] = "{$key}|=|{$value}";
        }

        $this->setHash(base64_encode(implode("|||", $arKeyValPair)));

        return $this->getHash();
    }

    /**
     * Gera senhas aleatórias
     *
     * @param int $length tamanho da senha
     *
     * @return string
     */
    public function generatePassword ($length = 6)
    {
        return substr(str_shuffle("aeiouyAEIOUYbdghjmnpqrstvzBDGHJLMNPQRSTVWXZ0123456789"), 0, $length);
    }

    public function setHash ($hash)
    {
        $this->hash = $hash;
    }

    public function getHash ()
    {
        return $this->hash;
    }

    /**
     * monta provider
     *
     * @param string $provider
     *
     * @return array
     */
    public function getResultProvider ($provider)
    {
        $rmMask = array('display(', 'value(', ')');

        $provider = explode('::', $provider);

        $result = array();

        if ((isset($provider[0])) && (isset($provider[1]))) {
            $namespace = $provider[0];
            $method = $provider[1];
            $display = ucfirst(str_replace($rmMask, '', $provider[2]));
            $keyvalue = ucfirst(str_replace($rmMask, '', $provider[3]));

            $business = new $namespace($this->container);

            foreach ($business->$method() as $value) {
                $getDisplay = 'get' . $display;
                $getValue = 'get' . $keyvalue;

                $object = new \stdClass();
                $object->display = $value->$getValue();
                $object->value = $value->$getDisplay();

                $result[] = $object;
            }
        }

        return $result;
    }

    /**
     * Método que realiza o decode do hash colocando como último elemento do array se está expirado ou não o hash
     *
     * @param string $hash
     *
     * @throws exception\ExceptionBusiness
     * @return array dados que o hash gerou
     */
    public function decodeHash ($hash)
    {
        $arDataPair = explode("|||", base64_decode($hash));
        foreach ($arDataPair as $data) {
            $arKeyValue = explode("|=|", $data);
            if (!isset($arKeyValue[0]) || !isset($arKeyValue[1])) {
                throw new ExceptionBusiness('Hash/Token Inválido!');
            }
            $arData[$arKeyValue[0]] = $arKeyValue[1];
        }
        $dateExp = array_pop($arData);

        $arData['expired'] = (boolean) (strtotime($dateExp) < strtotime(date("Y-m-d H:i:s")));
        return $arData;
    }

    /**
     * Adciona mensagens de exceção separadas por | ao array de mensagens de exceção.
     *
     * @param $strMessage
     */
    public function addStrMessage ($strMessage)
    {
        if ($strMessage) {
            $arrMessage = explode('|', $strMessage);

            foreach ($arrMessage as $message) {
                if (!empty($message)) {
                    $this->addMessage($message);
                }
            }
        }
    }

    public function addMessage ($message)
    {
        $this->result[] = $message;
    }

    public function getMessagesOfException ()
    {
        return $this->result;
    }

    public function exceptionMessages ()
    {
        if (0 < count($this->result)) {
            throw new ExceptionBusiness(implode('|', $this->result));
        }
    }

    /**
     * @param null $namespace
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public function getSession ($namespace = NULL)
    {
        return $this->container->get('request')->getSession();
    }

    /**
     * Atualiza usuário autenticado
     *
     * @param string $set
     * @param string|integer|object $value
     */
    public function setAuthenticateUser ($set, $value)
    {
        $this->model = 'Core\UserBundle\Model\UserModel';

        $set = 'set' . ucfirst($set);

        $user = $this->getAuthenticate();
        $user->$set($value);

        $this->getModel()->update($user);
    }

    /**
     * Retorna se há um usuário autenticado ou não.
     * @return boolean
     */
    public function isAuthenticated ()
    {
        $userData = $this->callService('CoreUser.UserBusiness')->find($this->getSession()->get('user'));

        return is_object($userData);
    }

    /**
     * Retorna o usuário atualmente autenticado, ou gera uma exceção HTTP quando
     * não há um usuário ou a sessão expirou.
     * @return \Core\OrthosBundle\Entity\Usuario
     * @throws HttpException
     */
    public function getAuthenticate ()
    {
        if (!$this->isAuthenticated()) {
            return new \Core\OrthosBundle\Entity\Usuario();
        }

        $userData = $this->callService('CoreUser.UserBusiness')->find($this->getSession()->get('user'));

        return $userData;

        $this->_throwSessionFailureException();
    }

    public function getClinica () {
        if ($this->getSession()->get('clinica')) {
            $clinica = $this->getSession()->get('clinica');
            $entity = $this->callService('Orthos.ClinicaBusiness')->find($clinica['sq_clinica']);
            return $entity;
        }

        $user = $this->getAuthenticate();
        return $user->getSqClinica();
    }

    public function getPerfis () {
        $user = $this->getAuthenticate();
        return $user->getPerfis();
    }

    private function _throwSessionFailureException ()
    {
        $debug = $this->container->getParameter("kernel.debug");
        if ($debug) {
            $message = "getAuthenticate() invoked with no valid user in session";
        } else {
            $message = "Session authentication failure";
        }
        throw new HttpException(ConstLayouts::HTTP_STATUS_SESSION_ERROR, $message);
    }

    public function getMasks ()
    {
        return new \abstraction\xysLibrary\mask\Mask();
    }

    public function getDateUtil ()
    {
        return new \abstraction\xysLibrary\date\DateUtil();
    }

    public function getValidates ()
    {
        return new \abstraction\xysLibrary\validate\Validate();
    }

    public function getXysLibrary ()
    {
        return new \abstraction\xysLibrary\XysLibrary();
    }

    /**
     * Retorna uma string contendo o path do bundle
     * @example getBundlePath('@CoreUserBundle')
     *
     * @param $bundle
     *
     * @return string
     */
    public function getBundlePath ($bundle)
    {
        return $this->container->get('kernel')->locateResource($bundle);
    }

    public function getTranslator ($text)
    {
        return $this->container->get('translator')->trans($text);
    }

    /**
     * Método que converte um objeto stdClass em um array
     *
     * @param $stdClassObj
     *
     * @return array
     */
    public function objectToArray ($stdClassObj)
    {
        if (is_object($stdClassObj)) {
            $stdClassObj = get_object_vars($stdClassObj);
        }

        if (is_array($stdClassObj)) {
            $function = __NAMESPACE__ . '\AbstractBusiness::objectToArray';
            $stdClassObj = array_map($function, $stdClassObj);
        }

        return $stdClassObj;
    }

    /**
     * Valida se o dado está vazio
     *
     * @param $value
     *
     * @return bool TRUE if empty
     */
    public function isEmpty ($value)
    {
        if ((isset($value)) && (!is_object($value))) {
            $trimValue = trim($value);
            return empty($trimValue);
        }
        return FALSE;
    }

    /**
     * Retorna uma URL contendo o endereço da imagem do usuário
     *
     * @param \Core\UserBundle\Entity\Users $entityUser
     *
     * @param null $no_image_profile
     *
     * @return string
     */
    public function getUserProfilePicture (\Core\UserBundle\Entity\Users $entityUser = NULL, $no_image_profile = NULL)
    {

        if ($entityUser) {
            $no_image_profile = $entityUser->getNoImageProfile();
        }

        return $this->getUserProfilePictureBySource($no_image_profile);
    }

    /**
     * Busca imagem de perfil pelo caminho
     * @param string $no_image_profile
     *
     * @return string
     */
    public function getUserProfilePictureBySource ($no_image_profile = NULL)
    {
        $request = $this->container->get('request');

        $profileImage = 'http://' . $request->getHttpHost() . $request->getBasePath() . '/' . ConstUser::PATH_PHOTO_DEFAULT;

        if ($no_image_profile) {
            $trueFile = realpath(\Core\UserBundle\ConstUser::PHOTO_DIR_TMP . '/' . $no_image_profile);
            if (file_exists($trueFile)) {
                $profileImage = 'http://' . $request->getHttpHost() . $request->getBasePath() . '/' . \Core\UserBundle\ConstUser::PHOTO_DIR_TMP . '/' . $no_image_profile;
            }
        }

        return $profileImage;
    }

    public function prepareMoney ($value) {
        return str_replace(',', '', $value);
    }
}
