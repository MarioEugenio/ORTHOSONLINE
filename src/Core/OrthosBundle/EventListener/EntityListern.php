<?php
/**
 * Created by IntelliJ IDEA.
 * User: marioeugenio
 * Date: 6/8/13
 * Time: 10:21 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Core\OrthosBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use abstraction\xysLibrary\XysLibrary;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\HttpKernel;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Core\OrthosBundle\Entity\Log;

class EntityListern
{
    private $_uri;
    private $container;

    /**
     * @param $annotation_reader
     * @param \Symfony\Bundle\FrameworkBundle\HttpKernel $httpkernell
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router $route
     * @param $container
     */
    public function __construct(HttpKernel $httpkernell,Router $route, $container)
    {
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
        $request = $event->getRequest();
        $base = $request->getBaseUrl();
        $this->_uri = str_replace($base, '', $request->getRequestUri());
    }

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
            'postFlush',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        //$this->index($args, 'update');
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        //$this->index($args, 'persist');
    }

    /*public function postFlush(PostFlushEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        $xml = simplexml_load_file(__DIR__ . '/../../../../app/config/log_list.xml');

        $check = array();
        $i=0;
        foreach ($xml->list->url as $url) {
            $check[$i]['text'] = (string) $url->attributes()->text;
            $check[$i]['message'] = (string) $url->attributes()->message;
            $check[$i]['type'] = (string) $url->attributes()->type;
            $i++;
        }

        foreach($check as $value) {
            if ($this->_uri == $value['text']) {

                if ('persist' == $value['type']) {
                    $log = new Log();
                    $log->setDtCadastro(new \DateTime());
                    $log->setTxMensagem($value['message']);
                    $log->setObEntity($entity);

                    $entityManager->persist($log);
                    $entityManager->flush();
                }
            }
        }
    }*/

    public function index(LifecycleEventArgs $args, $type)
    {
        /** @var $entity \abstraction\entity\AbstractEntity */
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        $xml = simplexml_load_file(__DIR__ . '/../../../../app/config/log_list.xml');

        $check = array();
        $i=0;
        foreach ($xml->list->url as $url) {
            $check[$i]['text'] = (string) $url->attributes()->text;
            $check[$i]['message'] = (string) $url->attributes()->message;
            $check[$i]['type'] = (string) $url->attributes()->type;
            $i++;
        }

        foreach($check as $value) {

            if ($this->_uri == $value['text']) {

                if ($type == $value['type']) {
                    $log = new Log();
                    $log->setDtCadastro(new \DateTime());
                    $log->setTxMensagem($value['message']);
                    $log->setObEntity(stripslashes($entity->toJson()));

                    $entityManager->persist($log);
                    $entityManager->flush();
                }
            }
        }
    }
}