<?php
/**
 * Classe Abstrata para Controller
 * @package abstraction\controller
 * @name AbstractController
 * @author Mário Eugênio <mario.oliveira@xys.com.br>
 * @version 0.0.1
 */
namespace abstraction\controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use abstraction\business\exception\ExceptionBusiness;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Response;


abstract class AbstractController extends Controller
{

    /**
     * Contém a classe instanciada por _getDefaultBusiness
     * @var object|string
     */
    protected $business;

    /**
     * Contém informações de rotas e paths
     * @var array
     */
    protected $allRouters;

    /**
     * Nome da conexão de banco a ser instânciada
     * @var string
     */
    protected $entityManager = NULL;

    /**
     * Retorna a conexão de banco instânciada
     * @return string
     */
    public function getEntityManager ()
    {
        return $this->entityManager;
    }

    public function convertToArray ($result) {
        $arrResult = array ();

        if ($result) {
            foreach ($result as $value) {
                $arrResult[] = $value->toArray();
            }
        }

        return $arrResult;
    }

    /**
     * Retorna se há um usuário autenticado ou não.
     * @return boolean
     */
    public function isAuthenticated ()
    {
        if (!$this->getSession()->get('user')) return FALSE;

        $userData = $this->get('CoreUser.UserBusiness')->find($this->getSession()->get('user'));
        return is_object($userData);
    }

    /**
     * Seta a conexão de banco a ser instânciada
     *
     * @param string $entityManager
     */
    public function setEntityManager ($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Return default module for crud
     * @throws \abstraction\business\exception\ExceptionBusiness
     * @return \abstraction\business\AbstractBusiness
     */
    protected function getBusiness ($business = NULL)
    {
        if ($business) {
            return new $business($this->container, $this->getEntityManager());
        }

        if (is_string($this->business)) {
            $this->business = new $this->business($this->container, $this->getEntityManager());
        }

        if (!$this->business instanceof \abstraction\business\AbstractBusiness) {
            throw new \abstraction\business\exception\ExceptionBusiness('Deve ser um objeto business');
        }

        return $this->business;
    }

    /**
     * retorna formulário unserialize
     *
     * @param bool $fullArray
     *
     * @return array
     */
    protected function getFormSerialized ($fullArray = FALSE)
    {
        $str = $this->getRequest()->get("form");
        if (!$str) {
            $str = $this->getRequest()->getContent();
        }

        if ($str) {
            $result = array();
            $arr = explode('&', $str);
            foreach ($arr as $val) {
                $unSerialize = explode('=', $val);
                if ($fullArray) {
                    // útil quando precisa pegar arrays vindos do form
                    $result[$unSerialize[0]][] = urldecode($unSerialize[1]);
                } else {
                    // Implementando correção do array vinda de um form
                    if (array_key_exists($unSerialize[0], $result) && !is_array($result[$unSerialize[0]])) {
                        $result[$unSerialize[0]] = array($result[$unSerialize[0]], urldecode($unSerialize[1]));
                    } else if (array_key_exists($unSerialize[0], $result) && is_array($result[$unSerialize[0]])) {
                        $result[$unSerialize[0]][] = urldecode($unSerialize[1]);
                    } else {
                        $result[$unSerialize[0]] = urldecode($unSerialize[1]);
                    }
                }
            }
            return $result;
        }
    }

    /**
     * Retorna os dados da requisição, caso tenham sido passados em JSON
     * @return array|null
     */
    protected function getRequestJson ()
    {
        $content = $this->getRequest()->getContent();
        return $content ? json_decode($content, TRUE) : NULL;
    }

    /**
     * Retorna resultado em formato Json
     *
     * @param mixed $result
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function responseJson ($result)
    {
        return new Response(json_encode($result));
    }

    public function responsePdf ($html) {
        return new Response($html);
    }

    /**
     * @param type $texto
     * @param type $sucess boolean
     * @param type $result array()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function responseMessage ($texto, $sucess = NULL, $result = NULL)
    {
        $message = $this->response(($texto), $sucess, $result);

        return new Response(json_encode($message));
    }

    private function sessionSecurity ()
    {
        $business = new \Core\UserBundle\Business\UserBusiness();
        $business->setContainer($this->container);
        if ($business->isAuthenticated()) {
            $user = $business->getAuthenticate();
            $security = new \Core\LayoutsBundle\Entity\Security();
            $security->setActiveDisplay(
                $user->getFlFirstAccess()
            );
            return $security->toArray();
        }

        return array();
    }

    protected function returnSecurityView (Array $result = NULL)
    {
        try {


            $security = $this->sessionSecurity();
            if (is_null($result)) {
                return $security;
            }
            return array_merge($result, $security);
        } catch (\abstraction\xysLibrary\security\exception\ExceptionSecurity $exc) {
            throw $exc;
        } catch (\Symfony\Component\Security\Core\Exception\AccessDeniedException $exc) {
            return $this->forward('CoreLayoutsBundle:Home:accessDenied');
        }
    }

    private function _security ()
    {
        if ($this->getControllerName() != 'login') {
            echo 'aqui';
            exit;
        }
    }

    /**
     * Método que gera uma resposta no formato array para a interface.
     *  É possível acessar as propriedades success, title, message e progressText
     *
     * @param mixed $variable
     * @param boolean $success
     * @param null $result
     *
     * @return array
     */
    private function response ($variable, $success = NULL, $result = NULL)
    {
        $message = array(
            "success" => $success,
            "title" => 'AVISO',
            "message" => $variable,
            "progressText" => 'Aguardando...',
            "result" => $result
        );

        return $message;
    }

    /**
     * Retorna todas rotas da Bundle
     * @return array
     */
    protected function getRouters ()
    {
        $routes = $this->container->get('router')->getRouteCollection()->all();
        $arrRoute = array();

        foreach ($routes as $key => $route) {
            $arrRoute[] = array("route" => $key, "path" => $route->getPattern());
        }

        return $arrRoute;
    }

    /**
     * Delegator para o controller
     *
     * @param string $method
     * @param args $args
     *
     * @throws BadMethodCallException
     * @return mixed
     */
    public function __call ($method, $args)
    {
        $model = $this->getModel();

        if (!method_exists($model, $method)) {
            throw new \Exception(sprintf('Método inexistente nesta model %s!', get_class($model)));
        }

        return call_user_func_array(array($model, $method), (array) $args);
    }

    /**
     * Método para invocar serviço instânciado para o bundle
     *
     * @param $service
     */
    public function callService ($service)
    {
        $container = $this->container->get($service);
        $container->setContainer($this->container);

        return $container;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public function getSession ()
    {
        return $this->container->get('request')->getSession();
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
            throw new \Symfony\Component\Security\Core\Exception\AuthenticationException('Usuário não autenticado');
        }

        $userData = $this->get('CoreUser.UserBusiness')->find($this->getSession()->get('user'));

        return $userData;


    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     */
    public function getClinica () {

        if ($this->getSession()->get('clinica')) {
            $clinica = $this->getSession()->get('clinica');
            $entity = $this->get('Orthos.ClinicaBusiness')->find($clinica['sq_clinica']);
            return $entity;
        }

        $user = $this->getAuthenticate();
        return $user->getSqClinica();
    }

    public function getPerfis () {
        $user = $this->getAuthenticate();
        return $user->getPerfis();
    }

    public function getMasks ()
    {
        return new \abstraction\xysLibrary\mask\Mask();
    }

    public function getValidates ()
    {
        return new \abstraction\xysLibrary\validate\Validate();
    }

    public function getXysLibrary ()
    {
        return new \abstraction\xysLibrary\XysLibrary();
    }

    public function getTranslator ($text,$params = array())
    {
        return $this->get('translator')->trans($text,$params);
    }

    /**
     * Retorna uma string contendo o path do bundle
     * @example getBundlePath('@CoreUserBundle')
     *
     * @param string $bundle
     *
     * @return string
     */
    public function getBundlePath ($bundle)
    {
        return $this->container->get('kernel')->locateResource($bundle);
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
        $dateExp = strftime("%F %H:%M:%S", $expire);

        $string = $dateExp;


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

        $namespace = $provider[0];
        $method = $provider[1];
        $display = ucfirst(str_replace($rmMask, '', $provider[2]));
        $keyvalue = ucfirst(str_replace($rmMask, '', $provider[3]));

        $business = new $namespace($this->container);

        $result = array();

        foreach ($business->$method() as $value) {
            $getDisplay = 'get' . $display;
            $getValue = 'get' . $keyvalue;


            $object = new \stdClass();
            $object->display = $value->$getValue();
            $object->value = $value->$getDisplay();

            $result[] = $object;
        }

        return $result;
    }

    /**
     * Método que realiza o decode do hash colocando como último elemento do array se está expirado ou não o hash
     *
     * @param string $hash
     *
     * @throws ExceptionBusiness
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
     * Get current controller name
     */
    public function getControllerName ()
    {
        $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
        $matches = array();
        preg_match($pattern, $this->getRequest()->get('_controller'), $matches);

        return strtolower($matches[1]);
    }

    /**
     * Get current action name
     */
    public function getActionName ()
    {
        $pattern = "#::([a-zA-Z]*)Action#";
        $matches = array();
        preg_match($pattern, $this->getRequest()->get('_controller'), $matches);

        return $matches[1];
    }

    /**
     * Retorna a propriedade da requisição
     * @param $param
     * @return mixed|null
     */
    public function getParameter ($param)
    {
        return $this->getRequest()->get($param);
    }

    /**
     * verifica parametros de request
     *
     * @param array $request
     *
     * @return array|null
     */
    public function checkParamSave (\Symfony\Component\HttpFoundation\Request $request = NULL)
    {
        if (($request->getMethod() == 'POST')) {
            foreach ($request->getQueryString() as $key => $value) {
                $request[$key] = (isset($request[$key])) ? $value : NULL;
            }

            return $request;
        }

        return NULL;
    }
}
