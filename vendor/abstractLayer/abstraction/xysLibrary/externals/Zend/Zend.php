<?php

namespace abstraction\xysLibrary\externals\Zend;

class Zend
{
    public function zendReflectionClass ($argument)
    {
        return new Zend_Reflection_Class($argument);
    }

    public function zendRegister ()
    {
        return \Zend_Registry::getInstance();
    }

    public static function zendSession ($namespace = 'general')
    {
        return new \Zend_Session_Namespace($namespace);
    }

    public function zendValidateEmailAddress ()
    {
        return new \Zend_Validate_EmailAddress();
    }

    public function zendAmfServer ()
    {
        return new \Zend_Amf_Server();
    }

    public function zendAmfRequest ()
    {
        return new \Zend_Amf_Request();
    }

    public function zendAmfRequestHttp ()
    {
        return new \Zend_Amf_Request_Http();
    }


    /**
     * Busca a instância do Zend_Db para conexões e retorna o adaptador de conexão com os métodos disponíveis
     * @param \Doctrine\ORM\EntityManager $em
     * @return \Zend_Db_Adapter_Abstract
     */
    public function db (\Doctrine\ORM\EntityManager $em)
    {
        $connection = $em->getConnection();
        try {

            $dbAdapter = \Zend_Db::factory($connection->getDriver()->getName(), array(
                'host' => $connection->getHost(),
                'port' => $connection->getPort(),
                'username' => $connection->getUsername(),
                'password' => $connection->getPassword(),
                'dbname' => $connection->getDatabase()
            ));

            $dbAdapter->getConnection();
        } catch (\Zend_Db_Adapter_Exception $excAdapter) {
            \Doctrine\Common\Util\Debug::dump($excAdapter);
            exit;
        } catch (\Zend_Exception $excZend) {
            \Doctrine\Common\Util\Debug::dump($excZend);
            exit;
        } catch (\Exception $excGeneric) {
            \Doctrine\Common\Util\Debug::dump($excGeneric);
            exit;
        }

        return $dbAdapter;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     */
    public function zendPaginator ($adapter)
    {
        return new \Zend_Paginator($adapter);
    }

    public function zendPaginatorAdapterArray ($adapter)
    {
        return new \Zend_Paginator_Adapter_Array($adapter);
    }

    public function zendLdap ($options = array())
    {
        return new \Zend_Ldap($options);
    }
}