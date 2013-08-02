<?php

namespace Orthos\Bundle\ProntuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProcedimentoController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\ProntuarioBundle\Business\ProcedimentoBusiness';


    /**
     * @Route("/orthos/procedimento/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/procedimento/save")
     */
    public function saveAction () {
        try {

            $form = $this->getRequestJson();

            $entity = new \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento();
            $entity->setObject($form);

            if ($form['ortodontia']) {
                $entity->setSqEspecialidade(
                    $this->get('Core.EspecialidadeBusiness')->find(1)
                );
            }

            if ($form['clinicaGeral']) {
                $entity->setSqEspecialidade(
                    $this->get('Core.EspecialidadeBusiness')->find(2)
                );
            }

            $entity->setSqClinica(
                $this->getClinica()
            );

            $entity->setFlAtivo(TRUE);

            $this->getBusiness()->save($entity);

            return $this->responseMessage('Cadastro realizado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/procedimento/autocomplete")
     */
    public function autocompleteAction()
    {
        $post = $this->getRequestJson();

        $especialidade = $this->get('Core.EspecialidadeBusiness');

        $entity = new \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento();
        $entity->setNoProcedimento($post['query']);
        $entity->setSqEspecialidade($especialidade->find($post['especialidade']));

        $business = $this->getBusiness();
        $return = $business->autocomplete($entity);

        return $this->responseJson($return);
    }
}
