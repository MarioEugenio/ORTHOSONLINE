<?php
namespace abstraction\test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AbstractTest extends WebTestCase
{
    const DB_TEST = 'test';
    const DB_DEFAULT = 'default';

    protected $_kernell;

    protected $_container;

    protected $_application;

    private $_modelMock;

    public function initTest ()
    {
        $this->_kernell = static::createKernel();
        $this->_kernell->boot();

        $this->_container = $this->_kernell->getContainer();
    }

    private function _initFixtureDbSchema ($schema = FALSE)
    {
        if ($schema) {
            $this->runConsole("doctrine:schema:drop", array("--force" => TRUE));
            $this->runConsole("doctrine:schema:create");
        }
    }

    public function initFixtures ($schema = FALSE, $pathFixtures=NULL)
    {
        $this->_application = new \Symfony\Bundle\FrameworkBundle\Console\Application($this->_kernell);
        $this->_application->setAutoExit(FALSE);

        $this->_initFixtureDbSchema($schema);

        if ($pathFixtures != NULL) {
            $this->runConsole("doctrine:fixtures:load", array("--fixtures" => $pathFixtures));
        } else {
            $this->runConsole("doctrine:fixtures:load", array("--em" => 'test'));
        }
    }

    protected function runConsole ($command, Array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = NULL;
        $options = array_merge($options, array('command' => $command));
        return $this->_application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    public function downTest ()
    {

    }

    public function initRequestMock ()
    {
        $this->_container->set('request', new \Core\UserBundle\Tests\Mock\MockRequest());
    }

    public function mockModel ($namespace, array $methods=NULL)
    {
        return $this->getMock($namespace, $methods);
    }

    public function mockMethod ($mockModel, $method,array $equalTo=NULL, $return=NULL)
    {
        $mockModel->expects($this->once())
            ->method($method)
            ->with($this->equalTo(current($equalTo)))
            ->will($this->returnValue($return));

        return $mockModel;
    }
}
