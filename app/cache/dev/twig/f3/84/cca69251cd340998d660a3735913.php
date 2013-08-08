<?php

/* ::base.html.twig */
class __TwigTemplate_f384cca69251cd340998d660a3735913 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'css' => array($this, 'block_css'),
            'js' => array($this, 'block_js'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\" ng-app=\"myApp\" >
<head>
    <meta charset=\"utf-8\" />
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
    <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 7
        $this->displayBlock('css', $context, $blocks);
        // line 8
        echo "    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />

    <script type=\"text/javascript\"> var baseUrl = \"";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "app"), "request"), "baseurl"), "html", null, true);
        echo "\"; </script>
    <script type=\"text/javascript\"> var uri = \"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "app"), "request"), "uri"), "html", null, true);
        echo "\"; </script>
    <script type=\"text/javascript\"> var assetBase = \"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "app"), "request"), "basePath"), "html", null, true);
        echo "\"; </script>

    ";
        // line 14
        $this->displayBlock('js', $context, $blocks);
        // line 15
        echo "</head>
<body class=\"bg-corp\">
";
        // line 17
        $this->displayBlock('body', $context, $blocks);
        // line 18
        echo "<div id=\"loading\">
    <div class=\"form-loading\">&nbsp;Carregando...</div>
</div>
</body>
</html>
";
    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
    }

    // line 7
    public function block_css($context, array $blocks = array())
    {
    }

    // line 14
    public function block_js($context, array $blocks = array())
    {
    }

    // line 17
    public function block_body($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 17,  82 => 14,  77 => 7,  72 => 6,  63 => 18,  55 => 14,  50 => 12,  46 => 11,  42 => 10,  34 => 7,  23 => 1,  106 => 41,  83 => 20,  80 => 19,  73 => 15,  69 => 14,  65 => 13,  61 => 17,  57 => 15,  53 => 10,  49 => 9,  45 => 8,  39 => 6,  36 => 8,  30 => 6,);
    }
}
