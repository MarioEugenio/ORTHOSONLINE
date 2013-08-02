<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Portal\Bundle\PortalBundle\PortalPortalBundle(),
            new Orthos\Bundle\AgendaBundle\OrthosAgendaBundle(),
            new Orthos\Bundle\PacienteBundle\OrthosPacienteBundle(),
            new Orthos\Bundle\MediaBundle\OrthosMediaBundle(),
            new Orthos\Bundle\FinanceiroBundle\OrthosFinanceiroBundle(),
            new Orthos\Bundle\RelatoriosBundle\OrthosRelatoriosBundle(),
            new Core\OrthosBundle\CoreOrthosBundle(),
            new Core\MessageBundle\CoreMessageBundle(),
            new Orthos\Bundle\ClinicaBundle\OrthosClinicaBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Bazinga\ExposeTranslationBundle\BazingaExposeTranslationBundle(),
            new Orthos\Bundle\ProntuarioBundle\OrthosProntuarioBundle(),
            new Snowcap\ImBundle\SnowcapImBundle(),
            new PunkAve\FileUploaderBundle\PunkAveFileUploaderBundle(),
            new Orthos\Bundle\MensagemBundle\OrthosMensagemBundle(),
            new Core\DashboardBundle\CoreDashboardBundle(),
            new Spraed\PDFGeneratorBundle\SpraedPDFGeneratorBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
