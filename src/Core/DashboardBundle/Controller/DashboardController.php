<?php

namespace Core\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Core\DashboardBundle\Business\DashboardBusiness';


    /**
     * @Route("/dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/dashboard/list/{posicao}")
     */
    public function listDashboardAction ($posicao) {
        $list = $this->getBusiness()->findBy(FALSE, array (
            'fl_posicao' => $posicao
        ));

        return $this->responseJson($list);
    }
}
