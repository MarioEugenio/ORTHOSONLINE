<?php

/* CoreOrthosBundle:Default:accessDenied.html.twig */
class __TwigTemplate_91043d47e8ce5ebf2908b042e7e0ea55 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'css' => array($this, 'block_css'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "ORTHOS";
    }

    // line 5
    public function block_css($context, array $blocks = array())
    {
        // line 6
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/bootstrap.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"
      xmlns=\"http://www.w3.org/1999/html\"/>
<link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/bootstrap-datepicker.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/bootstrap-responsive.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/layout.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/base.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/jquery.calendarPicker.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/stick.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/jquery.dataTables.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/bootstrap-timepicker.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />

";
    }

    // line 19
    public function block_body($context, array $blocks = array())
    {
        // line 20
        echo "<div class=\"navbar navbar-inverse navbar-fixed-top\">
    <div class=\"navbar-inner\">
        <div class=\"container\">
            <button type=\"button\" class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"brand\" href=\"#\">ORTHOS</a>

        </div>
    </div>
</div>

<div class=\"content row-fluid\" >

<div class=\"row-fluid\">
    <div class=\"span12 hero-unit back-color-1\">
        <div class=\"span2\">
            <ul class=\"thumbnails\">
                <li class=\"span12\">
                    <img src=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/img/img_error.png"), "html", null, true);
        echo "\" alt=\"\">
                </li>
            </ul>
        </div>
        <div class=\"span8\">
            <h3>O acesso a este endereço foi negado</h3>
            <p class=\"lead\">Por gentileza, acesse a página de autenticação e digite suas informações de acesso</p>
            <p class=\"pull-right\"><a class=\"btn btn-primary\" href=\"/login\">Página de Autenticação</button></a>
        </div>
    </div>
</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "CoreOrthosBundle:Default:accessDenied.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 41,  83 => 20,  80 => 19,  73 => 15,  69 => 14,  65 => 13,  61 => 12,  57 => 11,  53 => 10,  49 => 9,  45 => 8,  39 => 6,  36 => 5,  30 => 3,);
    }
}
