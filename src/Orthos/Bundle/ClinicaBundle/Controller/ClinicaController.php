<?php

namespace Orthos\Bundle\ClinicaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ClinicaController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\ClinicaBundle\Business\ClinicaBusiness';


    /**
     * @Route("/orthos/clinica")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/clinica/dashboard")
     * @Template()
     */
    public function dashboardAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/clinica/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        return array(
            'clinica' => NULL,
            'listBancos' => NULL,
            'listCadeiras' => NULL
        );
    }

    /**
     * @Route("/orthos/clinica/alterar/{id}")
     * @Template()
     */
    public function alterarAction($id)
    {
        $business = $this->getBusiness();
        $clinica = $business->find($id);

        /** @var $cadeiras \Orthos\Bundle\ClinicaBundle\Business\CadeiraBusiness */
        $cadeiras = $this->get('Orthos.CadeiraBusiness');
        $cadeiras = $cadeiras->findBy(FALSE, array('sq_clinica' => $clinica, 'fl_ativo' => true));

        /** @var $bancos \Orthos\Bundle\ClinicaBundle\Business\BancoBusiness */
        $bancos = $this->get('Orthos.BancoBusiness');
        $bancos = $bancos->findBy(FALSE, array('sq_clinica' => $clinica, 'fl_ativo' => true));

        $content = $this->renderView(
            'OrthosClinicaBundle:Clinica:cadastro.html.twig',
            array(
                'clinica' => json_encode($clinica->toArray()),
                'listBancos' => json_encode($bancos),
                'listCadeiras' => json_encode($cadeiras)
            )
        );

        return new \Symfony\Component\HttpFoundation\Response($content);
    }

    /**
     * @Route("/orthos/clinica/save")
     */
    public function saveAction () {
        try {
            $form['listContas'] = null;
            $form['listCadeiras'] = null;

            $form = $this->getRequestJson();
            $isEdit = FALSE;

            if (isset($form['sq_clinica'])) $isEdit = TRUE;

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sq_clinica']);
                $entity->setObject($form);
            } else {
                $entity = new \Orthos\Bundle\ClinicaBundle\Entity\Clinica($form);
                $entity->setFlAtivo(TRUE);
            }

            if (isset($form['default'])) {
                $entity->setFlDefault($form['default']);
            }

            $this->getBusiness()->save($entity, $form['listContas'], $form['listCadeiras']);

            if ($isEdit) {
                return $this->responseMessage("Alteração realizada com sucesso", TRUE);
            }

            return $this->responseMessage('Cadastro realizado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/clinica/search")
     */
    public function searchAction()
    {
        $business = $this->getBusiness();

        $form = $this->getRequestJson();
        $entity = new \Orthos\Bundle\ClinicaBundle\Entity\Clinica($form);

        $result = $business->search($entity);

        return $this->responseJson($this->convertToArray($result));
    }

    /**
     * @Route("/orthos/clinica/deletar/{id}")
     */
    public function deletarAction($id)
    {
        try {
            $entity = $this->getBusiness()->find($id);
            $entity->setFlAtivo(FALSE);

            $business = $this->getBusiness()->getModel()->getEntityManager();
            $business->persist($entity);
            $business->flush();

            return $this->responseMessage("Registro removido com sucesso", TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        } catch (\Exception $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }
}
