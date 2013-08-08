<?php
namespace Core\OrthosBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use abstraction\xysLibrary\XysLibrary;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\HttpKernel;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class BeforeControllerListener
{
    private $annotation_reader;

    private $xys_library;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\HttpKernel $httpKernell
     */
    private $httpKernell;

    private $router;

    private $container;

    private $uri;

    /**
     * @param $annotation_reader
     * @param \Symfony\Bundle\FrameworkBundle\HttpKernel $httpkernell
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router $route
     * @param $container
     */
    public function __construct($annotation_reader, HttpKernel $httpkernell,Router $route, $container)
    {
        $this->annotation_reader = $annotation_reader;
        $this->xys_library = new XysLibrary();
        $this->httpKernell = $httpkernell;
        $this->container = $container;
        $this->router = $route;

    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->_checkAccessUri($event);
    }

    private function _accessDenied (FilterControllerEvent $event)
    {
        $redirect = new RedirectResponse($this->router->generate('accessDenied'));
        $event->setController(function() use ($redirect) {
            return $redirect;
        });
    }

    private function _checkAccessUri (FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $base = $request->getBaseUrl();
        $uri = str_replace($base, '', $request->getRequestUri());

        $user = $request->getSession()->get('user');

        $xml = simplexml_load_file(__DIR__ . '/../../../../app/config/white_list.xml');

        $check = array();

        foreach ($xml->list->url as $url) {
            $check[] = (string) $url->attributes()->text;
        }

        if (!in_array($uri, $check)) {
            if (!$user) {
                $this->_accessDenied($event);
            }
        }
    }

}
