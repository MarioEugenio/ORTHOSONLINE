<?php

namespace Core\OrthosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TabelaPrecoController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Core\OrthosBundle\Business\TabelaPrecoBusiness';

    /**
     * @Route("/tabelaPreco")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/tabelaPreco/remover/{id}")
     * @Template()
     */
    public function removerAction($id)
    {
        try {
            $entity = $this->getBusiness()->find($id);
            $entity->setFlAtivo(FALSE);

            $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Registro removido com sucesso', true);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), false);
        }
    }

    /**
     * @Route("/tabelaPreco/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        return array(
            'tabelaPreco' => NULL
        );
    }

    /**
     * @Route("/tabelaPreco/alterar/{id}")
     * @Template()
     */
    public function alterarAction($id)
    {
        $business = $this->getBusiness();
        $entity = $business->find($id);

        $result = $entity->toArray();
        $result['sq_especialidade'] = $entity->getSqEspecialidade()->getSqEspecialidade();

        $content = $this->renderView(
            'CoreOrthosBundle:TabelaPreco:cadastro.html.twig',
            array(
                'tabelaPreco' => json_encode($result)
            )
        );

        return new \Symfony\Component\HttpFoundation\Response($content);
    }

    /**
     * @Route("/tabelaPreco/search")
     */
    public function searchAction () {
        $form = $this->getRequestJson();
        $entity = new \Core\OrthosBundle\Entity\TabelaPreco($form);

        $result = $this->getBusiness()->search($entity);

        return $this->responseJson($result);
    }

    /**
     * @Route("/tabelaPreco/save")
     */
    public function saveAction (){
        try {
            $form = $this->getRequestJson();
            $isEdit = FALSE;

            if (isset($form['sq_tabela_preco'])) {
                $isEdit = TRUE;
            }

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sq_tabela_preco']);
                $entity->setObject($form);
            } else {
                $entity = new \Core\OrthosBundle\Entity\TabelaPreco($form);
            }

            if (isset($form['sq_especialidade'])) {
                $entity->setSqEspecialidade(
                    $this->get('Core.EspecialidadeBusiness')->find($form['sq_especialidade'])
                );
            }

            $this->getBusiness()->save($entity);

            if ($isEdit) {
                return $this->responseMessage('Alteração realizada com sucesso', TRUE);
            }

            return $this->responseMessage('Cadastro realizado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }
}
