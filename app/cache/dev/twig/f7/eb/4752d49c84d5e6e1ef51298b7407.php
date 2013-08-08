<?php

/* CoreOrthosBundle:Default:index.html.twig */
class __TwigTemplate_f7eb4752d49c84d5e6e1ef51298b7407 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'css' => array($this, 'block_css'),
            'body' => array($this, 'block_body'),
            'js' => array($this, 'block_js'),
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
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/bootstrap-responsive.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/layout-login.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/base.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/css/stick.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" />

";
    }

    // line 14
    public function block_body($context, array $blocks = array())
    {
        // line 15
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

<div class=\"container\">
    <div class=\"row-fluid\">
        <div class=\"boxLogin-corp\">
            <div id=\"topRight\" class=\"back-box-login-corp\">
                <div class=\"marginBottom20\">
                    <h5 class=\"marginTop0\">Bem vindo ao ORTHOS ONLINE!</h5>
                </div>

                <form id=\"formLogin\" ng-controller=\"loginCtrl\" style=\"margin-bottom:0px;\">
                    <div id=\"alertLogin\"></div>
                    <div class=\"row\">
                        <div class=\"span12\">
                            <input id=\"login_ds_email\" ng-model=\"login.user\" class=\"width245 required\" type=\"email\" autofocus=\"\" tabindex=\"1\" placeholder=\"Login ou e-mail\" name=\"login_ds_email\">
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"span12\">
                            <input id=\"login_ds_password\" ng-model=\"login.password\" class=\"width245 required marginTop5\" type=\"password\" tabindex=\"1\" placeholder=\"Senha\" name=\"login_ds_password\">
                        </div>
                    </div>
                    <div class=\"row\" ng-show=\"listClinica.length\">
                        <div class=\"span12\">
                            <select  ng-model=\"login.sqClinica\" ng-change=\"autenticacao = false\" ng-options=\"item.sq_clinica as item.no_clinica for item in listClinica\"></select>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"span12\">
                            <button id=\"botao1\" ng-show=\"autenticacao == true\" ng-click=\"autenticar()\" class=\"btn btn-info\" type=\"button\">Entrar</button>
                            <button id=\"botao2\" ng-show=\"autenticacao == false\" ng-click=\"setClinica()\" class=\"btn btn-primary\" type=\"button\">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

";
    }

    // line 68
    public function block_js($context, array $blocks = array())
    {
        // line 69
        echo "<script type=\"text/javascript\" src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/jquery-1.9.1.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 70
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/bootstrap.js"), "html", null, true);
        echo "\"></script>

<script type=\"text/javascript\" src=\"";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/modal.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/sticky.min.js"), "html", null, true);
        echo "\"></script>

<script type=\"text/javascript\" src=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular/angular.min.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular/angular-resource.min.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular/angular-cookies.min.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 78
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular/angular-sanitize.min.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 79
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular/angular-bootstrap.min.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 80
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular/angular-bootstrap-prettify.min.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 81
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angular-directives/strap.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 82
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/externals/angularUI/build/angular-ui.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/diretivas.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\" src=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/form.js"), "html", null, true);
        echo "\"></script>

<script type=\"text/javascript\" src=\"";
        // line 86
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/javascript/Core.js"), "html", null, true);
        echo "\"></script>

<script type=\"text/javascript\" src=\"";
        // line 88
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/coreorthos/Usuario/js/login.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "CoreOrthosBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  190 => 88,  185 => 86,  180 => 84,  176 => 83,  172 => 82,  168 => 81,  164 => 80,  160 => 79,  156 => 78,  152 => 77,  148 => 76,  144 => 75,  139 => 73,  135 => 72,  130 => 70,  125 => 69,  122 => 68,  67 => 15,  64 => 14,  57 => 10,  53 => 9,  49 => 8,  45 => 7,  40 => 6,  37 => 5,  31 => 3,);
    }
}
