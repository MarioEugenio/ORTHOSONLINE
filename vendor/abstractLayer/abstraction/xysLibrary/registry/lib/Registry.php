<?php

namespace abstraction\xysLibrary\Registry\lib;

/**
 * @name Registry
 * @filesource Registry.php
 * @version 1.0 - 2011-07
 *
 * Registry class
 *
 * @uses
 * $myVar = 98784;
 * Registry::set('keyForValue', $myVar);
 *
 * in another part of code:
 *
 * $anotherVar = Registry::get('keyForValue');
 *
 * @author Gian Giacomo Ermacora
 * @author giangiacomo.ermacora@gmail.com
 *
 */
class Registry
{

    /**
     * The internal Instance
     * @var Registry
     */
    private static $instance = null;

    /**
     * Get value from key given
     *
     * @param string $key
     * @return misc
     */
    public static function get($key){
        return self::getInstance()->$key;
    }

    /**
     * Set inside registry a value identified by key
     *
     * @param string $key
     * @param misc $val
     */
    public static function set ($key, $val){
        if (!is_string($key)){
            return false;
        }
        self::getInstance()->$key = $val;
    }

    /**
     * Delete a value key paired from registry
     * @param string $key
     *
     * @return bool
     */
    public static function delete($key){
        $return = false;
        if (self::exist($key)){
            unset ( self::getInstance()->$key );
            $return = true;
        }
        return $return;
    }

    /**
     * Get trueif key given exist inside registry
     * @param string $key
     * @return boolean
     */
    public static function exist($key) {
        $return = false;
        if (self::getInstance()->$key){
            $return = true;
        }
        return $return;
    }

    /*** PRIVATE METHODS ***/

    public function __set($key, $val){
        $this->$key = $val;
    }

    public function __get($key){
        return $this->$key;
    }

    private static function getInstance() {
        if (!( self::$instance instanceof MockSession ) || self::$instance == null) {
            self::$instance = new MockSession();
        }
        return self::$instance;
    }

    public function __construct() {}
    private function __clone() {}

}
