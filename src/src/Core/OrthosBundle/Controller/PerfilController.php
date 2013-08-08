<?php

namespace Core\OrthosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PerfilController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Core\OrthosBundle\Business\PerfilBusiness';

    /**
     * @Route("/perfil/getAll")
     */
    public function getAllAction () {

        $business = $this->getBusiness();

        return $this->responseJson($business->findAll(FALSE));
    }
}
