<?php
namespace abstraction\xysLibrary\setup;

use abstraction\xysLibrary\setup\Exec;
use abstraction\xysLibrary\setup\Path;

class Install
{
    const XML_CONFIG = "/config/config.xml";
    const PATH_CONFIG = "app/config/";
    const PATH_APP = "app/";
    const PATH_SRC = "src/";

    private $_exec;

    private $_path;

    private $_xml;

    private $_container;

    private $_output;

    public function __construct ($container)
    {
        $this->addOutput('Iniciando processo de instalação');
        $this->_exec = new Exec();
        $this->_path = new Path();
        $this->_container = $container;

        $this->prepareXmlConfig();
    }

    private  function getConfig ()
    {
        return $this->_xml;
    }

    private function addOutput ($message)
    {
        $this->_output[] = $message;
    }

    private function prepareXmlConfig ()
    {

        if (file_exists(__DIR__.self::XML_CONFIG)) {
            $this->_xml = simplexml_load_file(__DIR__.self::XML_CONFIG);
            $this->addOutput('XML de configuração carregado.');
        } else {
            $this->addOutput('XML de configuração não existe.');
        }
    }

    public function execute ()
    {
        $config = $this->getConfig();
        $this->addOutput('Checando e instalando bootstrap.');
        if (!$this->_checksPathFileExist($config->bootstrap)) {
            $this->getExec()->executeShell(self::PATH_CONFIG.'config_cache.sh');
        }

        $this->addOutput('Checando e instalando parameters.');
        if (!$this->_checksPathFileExist($config->paramaters)) {
            $this->getExec()->executeShell(self::PATH_CONFIG.'config_parameters.sh');
        }

        $this->_checksCache();
        $this->_checksLogs();
        $this->_permissionsPath();

        return $this->_output;
    }

    protected function getExec ()
    {
        return $this->_exec;
    }

    protected function getPath ()
    {
        return $this->_path;
    }

    private function _permissionsPath ()
    {
        $this->addOutput('Verificando permissões de pasta.');

        $config = $this->getConfig();
        var_dump($config->permission); exit;
        foreach ($config->permission as $path) {

        }
    }

    private function _checksCache ()
    {
        $this->addOutput('Checando e instalando cache.');

        if (!$this->_checksPathFileExist(self::PATH_APP.'cache')) {
            mkdir (self::PATH_APP.'cache', 0755 );
        } else {
            $this->getPath()->recursiveChmod(self::PATH_APP.'cache');
        }
    }

    private function _checksLogs ()
    {
        $this->addOutput('Checando e instalando logs.');

        if (!$this->_checksPathFileExist(self::PATH_APP.'logs')) {
            mkdir (self::PATH_APP.'logs', 0755 );
        } else {
            $this->getPath()->recursiveChmod(self::PATH_APP.'logs');
        }
    }

    private function _checksPathFileExist ($path)
    {
        var_dump(file_exists(__DIR__."../../../../../".$path)); exit;
        if (!file_exists(__DIR__."/../../../".$path)) {
            return false;
        }

        return true;
    }
}
