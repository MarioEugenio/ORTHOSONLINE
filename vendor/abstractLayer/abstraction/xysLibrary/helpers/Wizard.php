<?php

namespace abstraction\xysLibrary\helpers;

/**
 * Classe que organiza informações para gerar wizards
 */
class Wizard
{
    private $_data;

    private $_idContainer;

    private $_initial;

    /**
     * construtor
     * @param string $idContainer
     * @param array $initial
     */
    public function __construct ($idContainer = NULL, Array $initial = NULL)
    {
        $this->_data = new \stdClass();
        $this->_data->page = array ();
        $this->_data->html = '';
        $this->_idContainer = $idContainer;
        $this->_initial = $initial;
    }

    /**
     * Adiciona nova página ao Wizard
     * @param string $route
     * @param string $title
     */
    public function addPage ($route, $title)
    {
        $this->_data->page[] = array ('route'=>$route, 'title-translate'=>$title);
    }

    private function _prepareJavascript ()
    {
        $this->_data->html .= '<script>'.PHP_EOL;
        $this->_data->html .= '$(document).ready(function () {'.PHP_EOL;
        $this->_data->html .= "   Wizard.inicialize('{$this->_initial[0]}');".PHP_EOL;
        $this->_data->html .= '});'.PHP_EOL;
        $this->_data->html .= '</script>'.PHP_EOL;
    }

    private function _prepareJavascriptNav ($idForm = NULL)
    {
        $html = '<script>'.PHP_EOL;
        $html .= '$(document).ready(function () {'.PHP_EOL;
        $html .= "   Wizard.inicializeNav('{$idForm}');".PHP_EOL;
        $html .= '});'.PHP_EOL;
        $html .= '</script>'.PHP_EOL;

        return $html;
    }

    /**
     * Monta a estrutura principal
     * @throws \Exception
     */
    private function _preparePage ()
    {
        if (!count ($this->_data->page)) {
            throw new \Exception('É necessário pelo menos um adicionar item para montagem do Wizard.');
        }

        $this->_data->html .= "<div id=\"{$this->_idContainer}\" class=\"marginTop20\">".PHP_EOL;
        //$this->_data->html .= '<div class="span2 ball-line-pointers"></div>'.PHP_EOL;

        $count = count($this->_data->page);
        foreach ($this->_data->page as $key => $value):
            if (0 == $key) {
                $this->_data->html .= '<div class="span2 alignCenter ball-wizard marginLeft0 fontBold">'.PHP_EOL;
            } else {
                if ($count == ($key + 1)) {
                    $this->_data->html .= '<div class="span2 alignCenter ball-wizard marginLeft0">'.PHP_EOL;
                } else {
                    $this->_data->html .= '<div class="span2 alignCenter ball-wizard marginLeft0">'.PHP_EOL;
                }
            }
            $page = $key+1;
            $this->_data->html .= "<a class=\"link-wizard {$value['route']} \" rel=\"{$value['route']}\">{$page}
            .{$value['title-translate']}</a>".PHP_EOL;
            $this->_data->html .= '</div>'.PHP_EOL;
        endforeach;

        $this->_data->html .= '<div class="span1 ball-line-pointers"></div>'.PHP_EOL;
        $this->_data->html .= '</div>'.PHP_EOL;
        $this->_data->html .= '<br/>'.PHP_EOL;
        $this->_data->html .= '<div id="wizard-container" class="container marginTop20 nav-container">'.PHP_EOL;
        $this->_data->html .= '</div>'.PHP_EOL;
    }

    /**
     * Monta barra de navegação
     */
    public function getNavigation ($idForm = NULL, $routePrev = NULL, $routeNext = NULL, $disableJs=FALSE)
    {
        $html = '';
        if (!$disableJs) {
            $html .= $this->_prepareJavascriptNav($idForm);
        }

        if ($routePrev) {
            $html .= '<input id="route-prev" name="route-prev" type="hidden" value="'.$routePrev.'" />'.PHP_EOL;
            $html .= '<a class="btn" id="nav-prev"><i class="icon-arrow-left"></i> Voltar</a>'.PHP_EOL;
        }
        if ($routeNext) {
            $html .= '<input id="route-next" name="route-next" type="hidden" value="'.$routeNext.'" />'.PHP_EOL;
            $html .= '<a class="btn" id="nav-next">Avançar <i class="icon-arrow-right"></i></a>'.PHP_EOL;
        }
        return $html;
    }

    /**
     * renderiza tela montada
     * @return string
     */
    public function render ()
    {
        $this->_prepareJavascript();
        $this->_preparePage();

        return $this->_decodeAccented($this->_data->html);
    }

    protected function _decodeAccented($encodedValue, $options = array()) {
        $options += array(
            'quote'     => ENT_NOQUOTES,
            'encoding'  => 'UTF-8',
        );
        return preg_replace_callback(
            '/&\w(acute|uml|tilde);/',
            create_function(
                '$m',
                'return html_entity_decode($m[0], ' . $options['quote'] . ', "' .
                $options['encoding'] . '");'
            ),
            $encodedValue
        );
    }
}