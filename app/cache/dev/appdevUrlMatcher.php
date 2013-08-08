<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appdevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appdevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        // _welcome
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_welcome');
            }

            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\WelcomeController::indexAction',  '_route' => '_welcome',);
        }

        // _demo_login
        if ($pathinfo === '/demo/secured/login') {
            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::loginAction',  '_route' => '_demo_login',);
        }

        // _security_check
        if ($pathinfo === '/demo/secured/login_check') {
            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::securityCheckAction',  '_route' => '_security_check',);
        }

        // _demo_logout
        if ($pathinfo === '/demo/secured/logout') {
            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::logoutAction',  '_route' => '_demo_logout',);
        }

        // acme_demo_secured_hello
        if ($pathinfo === '/demo/secured/hello') {
            return array (  'name' => 'World',  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  '_route' => 'acme_demo_secured_hello',);
        }

        // _demo_secured_hello
        if (0 === strpos($pathinfo, '/demo/secured/hello') && preg_match('#^/demo/secured/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',)), array('_route' => '_demo_secured_hello'));
        }

        // _demo_secured_hello_admin
        if (0 === strpos($pathinfo, '/demo/secured/hello/admin') && preg_match('#^/demo/secured/hello/admin/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloadminAction',)), array('_route' => '_demo_secured_hello_admin'));
        }

        // _demo
        if (rtrim($pathinfo, '/') === '/demo') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_demo');
            }

            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::indexAction',  '_route' => '_demo',);
        }

        // _demo_hello
        if (0 === strpos($pathinfo, '/demo/hello') && preg_match('#^/demo/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::helloAction',)), array('_route' => '_demo_hello'));
        }

        // _demo_contact
        if ($pathinfo === '/demo/contact') {
            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::contactAction',  '_route' => '_demo_contact',);
        }

        // _wdt
        if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::toolbarAction',)), array('_route' => '_wdt'));
        }

        if (0 === strpos($pathinfo, '/_profiler')) {
            // _profiler_search
            if ($pathinfo === '/_profiler/search') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',  '_route' => '_profiler_search',);
            }

            // _profiler_purge
            if ($pathinfo === '/_profiler/purge') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',  '_route' => '_profiler_purge',);
            }

            // _profiler_info
            if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]+)$#s', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::infoAction',)), array('_route' => '_profiler_info'));
            }

            // _profiler_import
            if ($pathinfo === '/_profiler/import') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',  '_route' => '_profiler_import',);
            }

            // _profiler_export
            if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]+)\\.txt$#s', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',)), array('_route' => '_profiler_export'));
            }

            // _profiler_phpinfo
            if ($pathinfo === '/_profiler/phpinfo') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::phpinfoAction',  '_route' => '_profiler_phpinfo',);
            }

            // _profiler_search_results
            if (preg_match('#^/_profiler/(?P<token>[^/]+)/search/results$#s', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',)), array('_route' => '_profiler_search_results'));
            }

            // _profiler
            if (preg_match('#^/_profiler/(?P<token>[^/]+)$#s', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array('_route' => '_profiler'));
            }

            // _profiler_redirect
            if (rtrim($pathinfo, '/') === '/_profiler') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_profiler_redirect');
                }

                return array (  '_controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::redirectAction',  'route' => '_profiler_search_results',  'token' => 'empty',  'ip' => '',  'url' => '',  'method' => '',  'limit' => '10',  '_route' => '_profiler_redirect',);
            }

        }

        if (0 === strpos($pathinfo, '/_configurator')) {
            // _configurator_home
            if (rtrim($pathinfo, '/') === '/_configurator') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_configurator_home');
                }

                return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
            }

            // _configurator_step
            if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]+)$#s', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',)), array('_route' => '_configurator_step'));
            }

            // _configurator_final
            if ($pathinfo === '/_configurator/final') {
                return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
            }

        }

        // core_dashboard_dashboard_index
        if ($pathinfo === '/dashboard') {
            return array (  '_controller' => 'Core\\DashboardBundle\\Controller\\DashboardController::indexAction',  '_route' => 'core_dashboard_dashboard_index',);
        }

        // core_dashboard_dashboard_listdashboard
        if (0 === strpos($pathinfo, '/dashboard/list') && preg_match('#^/dashboard/list/(?P<posicao>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\DashboardBundle\\Controller\\DashboardController::listDashboardAction',)), array('_route' => 'core_dashboard_dashboard_listdashboard'));
        }

        // core_dashboard_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\DashboardBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'core_dashboard_default_index'));
        }

        // orthos_mensagem_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\MensagemBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'orthos_mensagem_default_index'));
        }

        // orthos_mensagem_mensagem_index
        if ($pathinfo === '/orthos/mensagem') {
            return array (  '_controller' => 'Orthos\\Bundle\\MensagemBundle\\Controller\\MensagemController::indexAction',  '_route' => 'orthos_mensagem_mensagem_index',);
        }

        // orthos_mensagem_mensagem_listmensagens
        if (0 === strpos($pathinfo, '/orthos/mensagem/list') && preg_match('#^/orthos/mensagem/list/(?P<paciente>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\MensagemBundle\\Controller\\MensagemController::listMensagensAction',)), array('_route' => 'orthos_mensagem_mensagem_listmensagens'));
        }

        // orthos_mensagem_mensagem_enviar
        if ($pathinfo === '/orthos/mensagem/enviar') {
            return array (  '_controller' => 'Orthos\\Bundle\\MensagemBundle\\Controller\\MensagemController::enviarAction',  '_route' => 'orthos_mensagem_mensagem_enviar',);
        }

        // orthos_prontuario_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'orthos_prontuario_default_index'));
        }

        // orthos_prontuario_procedimento_cadastro
        if ($pathinfo === '/orthos/procedimento/cadastro') {
            return array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\ProcedimentoController::cadastroAction',  '_route' => 'orthos_prontuario_procedimento_cadastro',);
        }

        // orthos_prontuario_procedimento_save
        if ($pathinfo === '/orthos/procedimento/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\ProcedimentoController::saveAction',  '_route' => 'orthos_prontuario_procedimento_save',);
        }

        // orthos_prontuario_procedimento_autocomplete
        if ($pathinfo === '/orthos/procedimento/autocomplete') {
            return array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\ProcedimentoController::autocompleteAction',  '_route' => 'orthos_prontuario_procedimento_autocomplete',);
        }

        // orthos_prontuario_prontuario_cadastro
        if (0 === strpos($pathinfo, '/orthos/prontuario/cadastro') && preg_match('#^/orthos/prontuario/cadastro/(?P<paciente>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\ProntuarioController::cadastroAction',)), array('_route' => 'orthos_prontuario_prontuario_cadastro'));
        }

        // orthos_prontuario_prontuario_prontuario
        if (0 === strpos($pathinfo, '/orthos/prontuario/list') && preg_match('#^/orthos/prontuario/list/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\ProntuarioController::prontuarioAction',)), array('_route' => 'orthos_prontuario_prontuario_prontuario'));
        }

        // orthos_prontuario_prontuario_salvar
        if ($pathinfo === '/orthos/prontuario/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\ProntuarioBundle\\Controller\\ProntuarioController::salvarAction',  '_route' => 'orthos_prontuario_prontuario_salvar',);
        }

        // orthos_clinica_clinica_index
        if ($pathinfo === '/orthos/clinica') {
            return array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::indexAction',  '_route' => 'orthos_clinica_clinica_index',);
        }

        // orthos_clinica_clinica_dashboard
        if ($pathinfo === '/orthos/clinica/dashboard') {
            return array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::dashboardAction',  '_route' => 'orthos_clinica_clinica_dashboard',);
        }

        // orthos_clinica_clinica_cadastro
        if ($pathinfo === '/orthos/clinica/cadastro') {
            return array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::cadastroAction',  '_route' => 'orthos_clinica_clinica_cadastro',);
        }

        // orthos_clinica_clinica_alterar
        if (0 === strpos($pathinfo, '/orthos/clinica/alterar') && preg_match('#^/orthos/clinica/alterar/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::alterarAction',)), array('_route' => 'orthos_clinica_clinica_alterar'));
        }

        // orthos_clinica_clinica_save
        if ($pathinfo === '/orthos/clinica/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::saveAction',  '_route' => 'orthos_clinica_clinica_save',);
        }

        // orthos_clinica_clinica_search
        if ($pathinfo === '/orthos/clinica/search') {
            return array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::searchAction',  '_route' => 'orthos_clinica_clinica_search',);
        }

        // orthos_clinica_clinica_deletar
        if (0 === strpos($pathinfo, '/orthos/clinica/deletar') && preg_match('#^/orthos/clinica/deletar/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\ClinicaController::deletarAction',)), array('_route' => 'orthos_clinica_clinica_deletar'));
        }

        // orthos_clinica_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\ClinicaBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'orthos_clinica_default_index'));
        }

        // root
        if ($pathinfo === '/login') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\DefaultController::indexAction',  '_route' => 'root',);
        }

        // core_orthos_default_contato
        if ($pathinfo === '/contato') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\DefaultController::contatoAction',  '_route' => 'core_orthos_default_contato',);
        }

        // core_orthos_default_enviarcontato
        if ($pathinfo === '/contato/enviarContato') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\DefaultController::enviarContatoAction',  '_route' => 'core_orthos_default_enviarcontato',);
        }

        // accessDenied
        if ($pathinfo === '/accessDenied') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\DefaultController::accessDeniedAction',  '_route' => 'accessDenied',);
        }

        // core_orthos_default_inicial
        if ($pathinfo === '/orthos/inicial') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\DefaultController::inicialAction',  '_route' => 'core_orthos_default_inicial',);
        }

        // main
        if ($pathinfo === '/orthos/main') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\DefaultController::mainAction',  '_route' => 'main',);
        }

        // core_orthos_perfil_getall
        if ($pathinfo === '/perfil/getAll') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\PerfilController::getAllAction',  '_route' => 'core_orthos_perfil_getall',);
        }

        // core_orthos_tabelapreco_index
        if ($pathinfo === '/tabelaPreco') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\TabelaPrecoController::indexAction',  '_route' => 'core_orthos_tabelapreco_index',);
        }

        // core_orthos_tabelapreco_remover
        if (0 === strpos($pathinfo, '/tabelaPreco/remover') && preg_match('#^/tabelaPreco/remover/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\OrthosBundle\\Controller\\TabelaPrecoController::removerAction',)), array('_route' => 'core_orthos_tabelapreco_remover'));
        }

        // core_orthos_tabelapreco_cadastro
        if ($pathinfo === '/tabelaPreco/cadastro') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\TabelaPrecoController::cadastroAction',  '_route' => 'core_orthos_tabelapreco_cadastro',);
        }

        // core_orthos_tabelapreco_alterar
        if (0 === strpos($pathinfo, '/tabelaPreco/alterar') && preg_match('#^/tabelaPreco/alterar/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\OrthosBundle\\Controller\\TabelaPrecoController::alterarAction',)), array('_route' => 'core_orthos_tabelapreco_alterar'));
        }

        // core_orthos_tabelapreco_search
        if ($pathinfo === '/tabelaPreco/search') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\TabelaPrecoController::searchAction',  '_route' => 'core_orthos_tabelapreco_search',);
        }

        // core_orthos_tabelapreco_save
        if ($pathinfo === '/tabelaPreco/save') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\TabelaPrecoController::saveAction',  '_route' => 'core_orthos_tabelapreco_save',);
        }

        // core_orthos_usuario_index
        if ($pathinfo === '/usuario') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::indexAction',  '_route' => 'core_orthos_usuario_index',);
        }

        // core_orthos_usuario_remover
        if (0 === strpos($pathinfo, '/usuario/remover') && preg_match('#^/usuario/remover/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::removerAction',)), array('_route' => 'core_orthos_usuario_remover'));
        }

        // core_orthos_usuario_logoff
        if ($pathinfo === '/usuario/logoff') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::logoffAction',  '_route' => 'core_orthos_usuario_logoff',);
        }

        // core_orthos_usuario_alterarsenha
        if ($pathinfo === '/usuario/alterarSenha') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::alterarSenhaAction',  '_route' => 'core_orthos_usuario_alterarsenha',);
        }

        // core_orthos_usuario_savesenha
        if ($pathinfo === '/usuario/saveSenha') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::saveSenhaAction',  '_route' => 'core_orthos_usuario_savesenha',);
        }

        // core_orthos_usuario_definirclinica
        if ($pathinfo === '/usuario/definirClinica') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::definirClinicaAction',  '_route' => 'core_orthos_usuario_definirclinica',);
        }

        // core_orthos_usuario_autenticar
        if ($pathinfo === '/usuario/autenticar') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::autenticarAction',  '_route' => 'core_orthos_usuario_autenticar',);
        }

        // core_orthos_usuario_alterar
        if (0 === strpos($pathinfo, '/usuario/alterar') && preg_match('#^/usuario/alterar/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::alterarAction',)), array('_route' => 'core_orthos_usuario_alterar'));
        }

        // core_orthos_usuario_cadastro
        if ($pathinfo === '/usuario/cadastro') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::cadastroAction',  '_route' => 'core_orthos_usuario_cadastro',);
        }

        // core_orthos_usuario_save
        if ($pathinfo === '/usuario/save') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::saveAction',  '_route' => 'core_orthos_usuario_save',);
        }

        // core_orthos_usuario_search
        if ($pathinfo === '/usuario/search') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::searchAction',  '_route' => 'core_orthos_usuario_search',);
        }

        // core_orthos_usuario_atendente
        if ($pathinfo === '/orthos/usuario/atendente') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::atendenteAction',  '_route' => 'core_orthos_usuario_atendente',);
        }

        // core_orthos_usuario_medico
        if ($pathinfo === '/orthos/usuario/medico') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::medicoAction',  '_route' => 'core_orthos_usuario_medico',);
        }

        // core_orthos_usuario_getatendenteporid
        if (0 === strpos($pathinfo, '/orthos/usuario/search') && preg_match('#^/orthos/usuario/search/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::getAtendentePorIdAction',)), array('_route' => 'core_orthos_usuario_getatendenteporid'));
        }

        // core_orthos_usuario_deletar
        if (0 === strpos($pathinfo, '/usuario/deletar') && preg_match('#^/usuario/deletar/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::deletarAction',)), array('_route' => 'core_orthos_usuario_deletar'));
        }

        // core_orthos_usuario_getperfilmenus
        if ($pathinfo === '/usuario/getMenuPerfil') {
            return array (  '_controller' => 'Core\\OrthosBundle\\Controller\\UsuarioController::getPerfilMenusAction',  '_route' => 'core_orthos_usuario_getperfilmenus',);
        }

        // orthos_relatorios_default_baixas
        if ($pathinfo === '/relatorio/financeiro/baixas') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\DefaultController::baixasAction',  '_route' => 'orthos_relatorios_default_baixas',);
        }

        // orthos_relatorios_default_parcelas
        if ($pathinfo === '/relatorio/financeiro/parcelas') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\DefaultController::parcelasAction',  '_route' => 'orthos_relatorios_default_parcelas',);
        }

        // orthos_relatorios_default_receita
        if ($pathinfo === '/relatorio/financeiro/receita') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\DefaultController::receitaAction',  '_route' => 'orthos_relatorios_default_receita',);
        }

        // orthos_relatorios_default_inadimplencia
        if ($pathinfo === '/relatorio/financeiro/inadimplencia') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\DefaultController::inadimplenciaAction',  '_route' => 'orthos_relatorios_default_inadimplencia',);
        }

        // orthos_relatorios_financeiro_caixa
        if ($pathinfo === '/relatorio/bind/financeiro/baixas') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\FinanceiroController::caixaAction',  '_route' => 'orthos_relatorios_financeiro_caixa',);
        }

        // orthos_relatorios_financeiro_receitas
        if ($pathinfo === '/relatorio/bind/financeiro/receitas') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\FinanceiroController::receitasAction',  '_route' => 'orthos_relatorios_financeiro_receitas',);
        }

        // orthos_relatorios_financeiro_inadimplencia
        if ($pathinfo === '/relatorio/bind/financeiro/inadimplencia') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\FinanceiroController::inadimplenciaAction',  '_route' => 'orthos_relatorios_financeiro_inadimplencia',);
        }

        // orthos_relatorios_financeiro_parcelas
        if ($pathinfo === '/relatorio/bind/financeiro/parcelas') {
            return array (  '_controller' => 'Orthos\\Bundle\\RelatoriosBundle\\Controller\\FinanceiroController::parcelasAction',  '_route' => 'orthos_relatorios_financeiro_parcelas',);
        }

        // orthos_financeiro_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'orthos_financeiro_default_index'));
        }

        // orthos_financeiro_financeiro_orcamento
        if ($pathinfo === '/orthos/financeiro/orcamento') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::orcamentoAction',  '_route' => 'orthos_financeiro_financeiro_orcamento',);
        }

        // orthos_financeiro_financeiro_listparcelasatrasadapaciente
        if (0 === strpos($pathinfo, '/orthos/financeiro/listParcelasAtrasadaPaciente') && preg_match('#^/orthos/financeiro/listParcelasAtrasadaPaciente/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::listParcelasAtrasadaPacienteAction',)), array('_route' => 'orthos_financeiro_financeiro_listparcelasatrasadapaciente'));
        }

        // orthos_financeiro_financeiro_remessa
        if ($pathinfo === '/orthos/financeiro/remessa') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::remessaAction',  '_route' => 'orthos_financeiro_financeiro_remessa',);
        }

        // orthos_financeiro_financeiro_retorno
        if ($pathinfo === '/orthos/financeiro/retorno') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::retornoAction',  '_route' => 'orthos_financeiro_financeiro_retorno',);
        }

        // orthos_financeiro_financeiro_pagarparcela
        if ($pathinfo === '/orthos/financeiro/pagarParcela') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::pagarParcelaAction',  '_route' => 'orthos_financeiro_financeiro_pagarparcela',);
        }

        // orthos_financeiro_financeiro_chequedevolvido
        if ($pathinfo === '/orthos/financeiro/chequeDevolvido') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::chequeDevolvidoAction',  '_route' => 'orthos_financeiro_financeiro_chequedevolvido',);
        }

        // orthos_financeiro_financeiro_efetivarnegociacao
        if ($pathinfo === '/orthos/financeiro/efetivarNegociacao') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::efetivarNegociacaoAction',  '_route' => 'orthos_financeiro_financeiro_efetivarnegociacao',);
        }

        // orthos_financeiro_financeiro_gerarparcelas
        if ($pathinfo === '/orthos/financeiro/gerarParcelas') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::gerarParcelasAction',  '_route' => 'orthos_financeiro_financeiro_gerarparcelas',);
        }

        // orthos_financeiro_financeiro_list
        if (0 === strpos($pathinfo, '/orthos/financeiro/list') && preg_match('#^/orthos/financeiro/list/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::listAction',)), array('_route' => 'orthos_financeiro_financeiro_list'));
        }

        // orthos_financeiro_financeiro_boleto
        if (0 === strpos($pathinfo, '/orthos/financeiro/boleto') && preg_match('#^/orthos/financeiro/boleto/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FinanceiroController::boletoAction',)), array('_route' => 'orthos_financeiro_financeiro_boleto'));
        }

        // orthos_financeiro_fornecedor_search
        if ($pathinfo === '/orthos/financeiro/fornecedor/search') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::searchAction',  '_route' => 'orthos_financeiro_fornecedor_search',);
        }

        // orthos_financeiro_fornecedor_list
        if (0 === strpos($pathinfo, '/orthos/financeiro/fornecedor/list') && preg_match('#^/orthos/financeiro/fornecedor/list/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::listAction',)), array('_route' => 'orthos_financeiro_fornecedor_list'));
        }

        // orthos_financeiro_fornecedor_save
        if ($pathinfo === '/orthos/financeiro/fornecedor/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::saveAction',  '_route' => 'orthos_financeiro_fornecedor_save',);
        }

        // orthos_financeiro_fornecedor_remover
        if (0 === strpos($pathinfo, '/orthos/financeiro/fornecedor/remover') && preg_match('#^/orthos/financeiro/fornecedor/remover/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::removerAction',)), array('_route' => 'orthos_financeiro_fornecedor_remover'));
        }

        // orthos_financeiro_fornecedor_autocomplete
        if ($pathinfo === '/orthos/financeiro/fornecedor/autocomplete') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::autocompleteAction',  '_route' => 'orthos_financeiro_fornecedor_autocomplete',);
        }

        // orthos_financeiro_fornecedor_index
        if ($pathinfo === '/orthos/financeiro/fornecedor') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::indexAction',  '_route' => 'orthos_financeiro_fornecedor_index',);
        }

        // orthos_financeiro_fornecedor_alterar
        if (0 === strpos($pathinfo, '/orthos/financeiro/fornecedor/alterar') && preg_match('#^/orthos/financeiro/fornecedor/alterar/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::alterarAction',)), array('_route' => 'orthos_financeiro_fornecedor_alterar'));
        }

        // orthos_financeiro_fornecedor_cadastro
        if ($pathinfo === '/orthos/financeiro/fornecedor/cadastro') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\FornecedorController::cadastroAction',  '_route' => 'orthos_financeiro_fornecedor_cadastro',);
        }

        // orthos_financeiro_lancamentos_list
        if ($pathinfo === '/orthos/financeiro/lancamentos/list') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\LancamentosController::listAction',  '_route' => 'orthos_financeiro_lancamentos_list',);
        }

        // orthos_financeiro_lancamentos_index
        if ($pathinfo === '/orthos/financeiro/lancamentos') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\LancamentosController::indexAction',  '_route' => 'orthos_financeiro_lancamentos_index',);
        }

        // orthos_financeiro_lancamentos_save
        if ($pathinfo === '/orthos/financeiro/lancamentos/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\FinanceiroBundle\\Controller\\LancamentosController::saveAction',  '_route' => 'orthos_financeiro_lancamentos_save',);
        }

        // orthos_media_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\MediaBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'orthos_media_default_index'));
        }

        // media_upload
        if ($pathinfo === '/orthos/media') {
            return array (  '_controller' => 'Orthos\\Bundle\\MediaBundle\\Controller\\MediaController::indexAction',  '_route' => 'media_upload',);
        }

        // orthos_media_media_upload
        if ($pathinfo === '/orthos/media/upload') {
            return array (  '_controller' => 'Orthos\\Bundle\\MediaBundle\\Controller\\MediaController::uploadAction',  '_route' => 'orthos_media_media_upload',);
        }

        // orthos_paciente_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'orthos_paciente_default_index'));
        }

        // orthos_paciente_paciente_index
        if ($pathinfo === '/orthos/paciente') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::indexAction',  '_route' => 'orthos_paciente_paciente_index',);
        }

        // orthos_paciente_paciente_listindicacao
        if (0 === strpos($pathinfo, '/orthos/paciente/listIndicacao') && preg_match('#^/orthos/paciente/listIndicacao/(?P<paciente>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::listIndicacaoAction',)), array('_route' => 'orthos_paciente_paciente_listindicacao'));
        }

        // orthos_paciente_paciente_indicarpaciente
        if ($pathinfo === '/orthos/paciente/indicarPaciente') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::indicarPacienteAction',  '_route' => 'orthos_paciente_paciente_indicarpaciente',);
        }

        // orthos_paciente_paciente_transferencia
        if ($pathinfo === '/orthos/paciente/transferencia') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::transferenciaAction',  '_route' => 'orthos_paciente_paciente_transferencia',);
        }

        // orthos_paciente_paciente_transferir
        if (0 === strpos($pathinfo, '/orthos/paciente/transferir') && preg_match('#^/orthos/paciente/transferir/(?P<paciente>[^/]+)/(?P<clinica>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::transferirAction',)), array('_route' => 'orthos_paciente_paciente_transferir'));
        }

        // orthos_paciente_paciente_indicar
        if ($pathinfo === '/orthos/paciente/indicar') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::indicarAction',  '_route' => 'orthos_paciente_paciente_indicar',);
        }

        // orthos_paciente_paciente_enviarmensagem
        if ($pathinfo === '/orthos/paciente/enviarMensagem') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::enviarMensagemAction',  '_route' => 'orthos_paciente_paciente_enviarmensagem',);
        }

        // orthos_paciente_paciente_consultas
        if (0 === strpos($pathinfo, '/orthos/paciente/consultas') && preg_match('#^/orthos/paciente/consultas/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::consultasAction',)), array('_route' => 'orthos_paciente_paciente_consultas'));
        }

        // orthos_paciente_paciente_consultaspesquisa
        if (0 === strpos($pathinfo, '/orthos/paciente/consultasPesquisa') && preg_match('#^/orthos/paciente/consultasPesquisa/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::consultasPesquisaAction',)), array('_route' => 'orthos_paciente_paciente_consultaspesquisa'));
        }

        // orthos_paciente_paciente_prontuario
        if (0 === strpos($pathinfo, '/orthos/paciente/prontuario') && preg_match('#^/orthos/paciente/prontuario/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::prontuarioAction',)), array('_route' => 'orthos_paciente_paciente_prontuario'));
        }

        // orthos_paciente_paciente_financeiro
        if (0 === strpos($pathinfo, '/orthos/paciente/financeiro') && preg_match('#^/orthos/paciente/financeiro/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::financeiroAction',)), array('_route' => 'orthos_paciente_paciente_financeiro'));
        }

        // orthos_paciente_paciente_mensagens
        if (0 === strpos($pathinfo, '/orthos/paciente/mensagens') && preg_match('#^/orthos/paciente/mensagens/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::mensagensAction',)), array('_route' => 'orthos_paciente_paciente_mensagens'));
        }

        // orthos_paciente_paciente_indicacao
        if (0 === strpos($pathinfo, '/orthos/paciente/indicacao') && preg_match('#^/orthos/paciente/indicacao/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::indicacaoAction',)), array('_route' => 'orthos_paciente_paciente_indicacao'));
        }

        // orthos_paciente_paciente_find
        if (0 === strpos($pathinfo, '/orthos/paciente/find') && preg_match('#^/orthos/paciente/find/(?P<paciente>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::findAction',)), array('_route' => 'orthos_paciente_paciente_find'));
        }

        // orthos_paciente_paciente_alteracao
        if (0 === strpos($pathinfo, '/orthos/paciente/alteracao') && preg_match('#^/orthos/paciente/alteracao/(?P<paciente>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::alteracaoAction',)), array('_route' => 'orthos_paciente_paciente_alteracao'));
        }

        // orthos_paciente_paciente_cadastro
        if ($pathinfo === '/orthos/paciente/cadastro') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::cadastroAction',  '_route' => 'orthos_paciente_paciente_cadastro',);
        }

        // orthos_paciente_paciente_search
        if ($pathinfo === '/orthos/paciente/list') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::searchAction',  '_route' => 'orthos_paciente_paciente_search',);
        }

        // orthos_paciente_paciente_autocomplete
        if ($pathinfo === '/orthos/paciente/autocomplete') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::autocompleteAction',  '_route' => 'orthos_paciente_paciente_autocomplete',);
        }

        // orthos_paciente_paciente_getpacienteporid
        if (0 === strpos($pathinfo, '/orthos/paciente/search') && preg_match('#^/orthos/paciente/search/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::getPacientePorIdAction',)), array('_route' => 'orthos_paciente_paciente_getpacienteporid'));
        }

        // orthos_paciente_paciente_pagarcartao
        if ($pathinfo === '/orthos/paciente/pagamentoCartao') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::pagarCartaoAction',  '_route' => 'orthos_paciente_paciente_pagarcartao',);
        }

        // orthos_paciente_paciente_pagamento
        if (0 === strpos($pathinfo, '/orthos/paciente/pagamento') && preg_match('#^/orthos/paciente/pagamento/(?P<id>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::pagamentoAction',)), array('_route' => 'orthos_paciente_paciente_pagamento'));
        }

        // orthos_paciente_paciente_negociacao
        if (0 === strpos($pathinfo, '/orthos/paciente/negociacao') && preg_match('#^/orthos/paciente/negociacao/(?P<parcelas>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::negociacaoAction',)), array('_route' => 'orthos_paciente_paciente_negociacao'));
        }

        // orthos_paciente_paciente_removerparcelas
        if (0 === strpos($pathinfo, '/orthos/paciente/removerParcelas') && preg_match('#^/orthos/paciente/removerParcelas/(?P<parcelas>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::removerParcelasAction',)), array('_route' => 'orthos_paciente_paciente_removerparcelas'));
        }

        // orthos_paciente_paciente_saveprontuario
        if ($pathinfo === '/orthos/paciente/saveProntuario') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::saveProntuarioAction',  '_route' => 'orthos_paciente_paciente_saveprontuario',);
        }

        // orthos_paciente_paciente_save
        if ($pathinfo === '/orthos/paciente/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\PacienteBundle\\Controller\\PacienteController::saveAction',  '_route' => 'orthos_paciente_paciente_save',);
        }

        // orthos_agenda_agenda_save
        if ($pathinfo === '/orthos/agenda/save') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\AgendaController::saveAction',  '_route' => 'orthos_agenda_agenda_save',);
        }

        // orthos_agenda_agenda_checkstatusagenda
        if ($pathinfo === '/orthos/agenda/checkStatus') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\AgendaController::checkStatusAgenda',  '_route' => 'orthos_agenda_agenda_checkstatusagenda',);
        }

        // orthos_agenda_agenda_status
        if (0 === strpos($pathinfo, '/orthos/agenda/status') && preg_match('#^/orthos/agenda/status/(?P<sqAgenda>[^/]+)/(?P<sqStatus>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\AgendaController::statusAction',)), array('_route' => 'orthos_agenda_agenda_status'));
        }

        // orthos_agenda_agenda_load
        if ($pathinfo === '/orthos/agenda/load') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\AgendaController::loadAction',  '_route' => 'orthos_agenda_agenda_load',);
        }

        // orthos_agenda_agenda_remover
        if ($pathinfo === '/orthos/agenda/remover') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\AgendaController::removerAction',  '_route' => 'orthos_agenda_agenda_remover',);
        }

        // orthos_agenda_default_dashboardlistadiaria
        if ($pathinfo === '/dashboard/agenda/listaDiaria') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\DefaultController::dashboardListaDiariaAction',  '_route' => 'orthos_agenda_default_dashboardlistadiaria',);
        }

        // Orthos_Agenda
        if ($pathinfo === '/orthos/agenda') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\DefaultController::indexAction',  '_route' => 'Orthos_Agenda',);
        }

        // Orthos_Agendar
        if ($pathinfo === '/orthos/agendar') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\DefaultController::agendarAction',  '_route' => 'Orthos_Agendar',);
        }

        // Orthos_Agenda_Observacao
        if ($pathinfo === '/orthos/observacao') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\DefaultController::observacaoAction',  '_route' => 'Orthos_Agenda_Observacao',);
        }

        // Orthos_Agenda_Remover
        if ($pathinfo === '/orthos/remover') {
            return array (  '_controller' => 'Orthos\\Bundle\\AgendaBundle\\Controller\\DefaultController::removerAction',  '_route' => 'Orthos_Agenda_Remover',);
        }

        // portal_portal_default_index
        if (0 === strpos($pathinfo, '/portal') && preg_match('#^/portal/(?P<name>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Portal\\Bundle\\PortalBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'portal_portal_default_index'));
        }

        // message_index
        if ($pathinfo === '/message/index') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::indexAction',  '_route' => 'message_index',);
        }

        // message_list_inbox
        if ($pathinfo === '/message/listMessage') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::messageAction',  '_route' => 'message_list_inbox',);
        }

        // message_inbox
        if ($pathinfo === '/message/inbox') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::inboxAction',  '_route' => 'message_inbox',);
        }

        // message_sent
        if ($pathinfo === '/message/sent') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::sentAction',  '_route' => 'message_sent',);
        }

        // message_new
        if ($pathinfo === '/message/savenew') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::saveNewAction',  '_route' => 'message_new',);
        }

        // message_send_message
        if ($pathinfo === '/message/sendmessage') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::sendMessageAction',  '_route' => 'message_send_message',);
        }

        // message_show
        if (0 === strpos($pathinfo, '/message/show') && preg_match('#^/message/show/(?P<coMessage>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::showAction',)), array('_route' => 'message_show'));
        }

        // message_search
        if ($pathinfo === '/message/search') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::searchAction',  '_route' => 'message_search',);
        }

        // message_remove
        if (0 === strpos($pathinfo, '/message/removeMessage') && preg_match('#^/message/removeMessage/(?P<box>[^/]+)$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::removeMessageAction',)), array('_route' => 'message_remove'));
        }

        // CoreMessage_Message_last_messages
        if ($pathinfo === '/message/lastMessagesWithoutRead') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::lastMessagesWithoutReadAction',  '_route' => 'CoreMessage_Message_last_messages',);
        }

        // message_index_test
        if ($pathinfo === '/message/test') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::countMessageAction',  '_route' => 'message_index_test',);
        }

        // CoreMessage_Message_total_unread
        if ($pathinfo === '/message/getTotalUnreadMessage') {
            return array (  '_controller' => 'Core\\MessageBundle\\Controller\\MessageController::getTotalUnreadMessageAction',  '_route' => 'CoreMessage_Message_total_unread',);
        }

        // fos_js_routing_js
        if (0 === strpos($pathinfo, '/js/routing') && preg_match('#^/js/routing(?:\\.(?P<_format>js|json))?$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'fos_js_routing.controller:indexAction',  '_format' => 'js',)), array('_route' => 'fos_js_routing_js'));
        }

        // bazinga_exposetranslation_js
        if (0 === strpos($pathinfo, '/i18n') && preg_match('#^/i18n/(?P<domain_name>[^/]+)/(?P<_locale>[^/\\.]+)(?:\\.(?P<_format>js))?$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'bazinga.exposetranslation.controller:exposeTranslationAction',  'domain_name' => 'messages',  '_format' => 'js',)), array('_route' => 'bazinga_exposetranslation_js'));
        }

        // snowcap_im_default_index
        if (0 === strpos($pathinfo, '/cache/im') && preg_match('#^/cache/im/(?P<format>[^/]+)/(?P<path>(.+))$#s', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Snowcap\\ImBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'snowcap_im_default_index'));
        }

        // snowcap_im_default_test
        if ($pathinfo === '/cache/im/test') {
            return array (  '_controller' => 'Snowcap\\ImBundle\\Controller\\DefaultController::testAction',  '_route' => 'snowcap_im_default_test',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
