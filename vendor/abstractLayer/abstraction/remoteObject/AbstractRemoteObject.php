<?php
/**
 * Created by IntelliJ IDEA.
 * User: marioeugenio
 * Date: 8/23/12
 * Time: 11:16 AM
 * To change this template use File | Settings | File Templates.
 */
namespace abstraction\remoteObject;

abstract class AbstractRemoteObject extends \abstraction\container\Container
{
    protected $_kernell;

    protected $_container;

    protected $_amf;

    public function __construct ()
    {
        $this->_kernell = static::createKernel();
        $this->_kernell->boot();
        $this->_container = $this->_kernell->getContainer();
    }

    public function getKernell ()
    {
        return $this->_kernell;
    }

    public function getContainer ()
    {
        return $this->_container;
    }

    public function responseRO ($message=NULL, $return=NULL)
    {
        return array (
            'message' => $message,
            'return' => $return
        );
    }
}
