<?php

/**
 * Classe Abstrata para Entity
 *
 * @package abstraction\entity
 * @name AbstractEntity
 * @author Mário Eugênio <mario.oliveira@xys.com.br>
 * @version 0.0.1
 */

namespace abstraction\entity;

abstract class AbstractEntity
{

    public function __construct (Array $data = NULL)
    {
        if ($data) {
            $this->setObject($data);
        }
    }

    private function underscore2Camelcase ($str)
    {
        $words = explode('_', strtolower($str));

        $return = '';
        foreach ($words as $word) {
            $return .= ucfirst(trim($word));
        }

        return $return;
    }

    public function setObject (Array $array)
    {
        if ($array) {
            foreach ($array as $key => $value) {
                $set = "set" . $this->underscore2Camelcase($key);

                if (substr($key, 0,2) != 'sq') {
                    if (method_exists($this, $set)) {
                        $this->$set($value);
                    }
                }
            }
        }
    }

    /**
     * Retorna a entity como um array
     * @return type
     */
    public function toArray ($class=NULL)
    {
        $arPropriedades = array();

        $metodos = get_class_methods(get_class($this));

        foreach ($metodos as $metodo) {
            if (substr($metodo, 0, 3) == 'get') {

                $arPropriedades[substr($this->fromCamelCase($metodo), 4)] = $this->$metodo();
            }
        }

        return $arPropriedades;
    }

    /**
     * Retorna a entity como um array
     * @return type
     */
    public function toJson ($class=NULL)
    {
        $arPropriedades = array();

        $metodos = get_class_methods(get_class($this));

        foreach ($metodos as $metodo) {
            if (substr($metodo, 0, 3) == 'get') {

                $arPropriedades[substr($this->fromCamelCase($metodo), 4)] = $this->$metodo();
            }
        }

        return json_encode($arPropriedades);
    }

    /**
     * Retorna apenas atributos setados, os que forem NULL não serão retornados
     * @return array
     */
    public function toArrayNotNull ()
    {
        $arProperties = $this->toArray();
        foreach ($arProperties as $key => $value) {
            if (is_null($value)) {
                unset($arProperties[$key]);
            }
        }
        return $arProperties;
    }

    /**
     * Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
     * @param    string   $str    String in camel case format
     * @return    string            $str Translated into underscore format
     */
    public function fromCamelCase ($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

    /**
     * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
     * @param    string   $str                     String in underscore format
     * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
     * @return   string                              $str translated into camel caps
     */
    public function toCamelCase ($str, $capitalise_first_char = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }
}