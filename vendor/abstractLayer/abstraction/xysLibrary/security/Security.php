<?php
/**
 * Created by IntelliJ IDEA.
 * User: marioeugenio
 * Date: 7/11/12
 * Time: 2:25 PM
 * To change this template use File | Settings | File Templates.
 */
namespace abstraction\xysLibrary\security;

use abstraction\xysLibrary\security\exception\ExceptionSecurity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Security
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $_request;

    /**
     * @var array
     */
    private $_permission;

    /**
     * @var array
     */
    private $_white_list;

    /**
     * Construtor classe security
     */
    public function __construct (Request $request)
    {
        $this->_request = $request;
    }

    /**
     * retorna a funcionalidade em execução
     *
     * @return string
     */
    public function getUriFunctionality ()
    {
        return $this->_request->get('_route');
    }

    /**
     * retorna a controller em execução
     *
     * @return string
     */
    public function getController ()
    {
        $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
        $matches = array();
        preg_match($pattern, $this->_request->get('_controller'), $matches);

        if (isset($matches[1])) {
            return strtolower($matches[1]);
        }

        return;
    }

    /**
     * retorna a action em execução
     *
     * @return string
     */
    public function getAction ()
    {
        $pattern = "#::([a-zA-Z]*)Action#";
        $matches = array();
        preg_match($pattern, $this->_request->get('_controller'), $matches);

        if (isset($matches[1])) {
            return strtolower($matches[1]);
        }

        return;
    }

    /**
     * Seta as permissões do usuário logado necessárias para acesso
     *
     * @param array $permissions
     *
     * @throws exception\ExceptionSecurity
     */
    public function setPermission (Array $permissions=NULL)
    {
        if (!$this->_validPermissions($permissions)) {
            throw new ExceptionSecurity('As permissões setadas são de formato inválido');
        }

        $this->_permission = $permissions;
    }

    /**
     * seta lista para acesso externo
     *
     * @param array $list
     */
    public function setWhiteListAccess (Array $list=NULL)
    {
        $this->_white_list = $list;
    }

    /**
     * retorna as permissões do usuário logado
     *
     * @return array
     */
    protected function getPermission ()
    {
        return $this->_permission;
    }

    /**
     * checa se o acesso para o usuário logado é permitido
     *
     * @return bool
     * @throws exception\ExceptionSecurity
     */
    public function checkAccessUri ()
    {
        if (!count($this->getPermission())) {
            throw new AccessDeniedException();
        }

        foreach ($this->getPermission() as $access) {
            if (array_search($this->getUriFunctionality(), $access)) {
                throw new AccessDeniedException();
            }
        }

        return TRUE;
    }

    public function checkWhiteListAccess ()
    {
        if ((substr(strtolower($this->getUriFunctionality()),0,8) == '_assetic') ||
            (substr(strtolower($this->getUriFunctionality()),0,4) == 'fos_') ||
            (substr(strtolower($this->getUriFunctionality()),0,8) == 'bazinga_') ||
            $this->getUriFunctionality() == "_internal"
        ) {
            return TRUE;
        }
        
        if ($this->_white_list) {
            /** @var Core/UserBundle/Entity/WhiteListAccess $list */
            foreach($this->_white_list as $list) {
                if (substr(strtolower($list->getRouters()->getDsRouter()),0,8) == '_assetic') {
                    return TRUE;
                }

                if (strtolower($list->getRouters()->getDsRouter()) == strtolower($this->getUriFunctionality())) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    /**
     * checa se o usuário logado tem permissão a funcionalidade específica
     *
     * @param $functionality
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws exception\ExceptionSecurity
     * @return bool
     */
    public function checkAccessFunctionality ($functionality)
    {
        if (!count($this->getPermission())) {
            throw new AccessDeniedException();
        }

        if (!is_string ($functionality)) {
            throw new ExceptionSecurity('Funcionalidade em formato inválido');
        }

        $permission = $this->getPermission();
        $key = array_search($this->getUriFunctionality(), $permission);

        if (isset ($permission[$key])) {
            if (isset ($permission[$key]['functionality'])) {
                $arrFunctionality = array_search($functionality, $permission[$key]['functionality']);

                if (count ($arrFunctionality) > 1) {
                    throw new ExceptionSecurity('Existe funcionalidades duplicadas para esta funcionalidade pai');
                }

                if (count ($arrFunctionality) == 1) {
                    return TRUE;
                }
            }
        }

        throw new AccessDeniedException();
    }

    /**
     * valida a permissão setada
     *
     * @param array $permissions
     *
     * @return bool
     */
    private function _validPermissions (Array $permissions)
    {
        if (count($permissions) > 0) {
            foreach ($permissions as $access) {
                if (is_array($access)) {
                    if ((array_key_exists ('acl', $access))
                        && (array_key_exists ('id', $access))) {
                        return TRUE;
                    }
                } else {
                    return FALSE;
                }
            }
        }

        return FALSE;
    }
}
