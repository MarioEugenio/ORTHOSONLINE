<?php

namespace Orthos\Bundle\FinanceiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FornecedorController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\FinanceiroBundle\Business\FornecedorBusiness';

    /**
     * @Route("/orthos/financeiro/fornecedor/search")
     */
    public function searchAction () {
        $form = $this->getRequestJson();

        $result = $this->getBusiness()->getFornecedor(
            new \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor($form)
        );

        return $this->responseJson(
            $this->convertToArray($result)
        );
    }

    /**
     * @Route("/orthos/financeiro/fornecedor/list/{id}")
     */
    public function listAction ($id) {

        $result = $this->getBusiness()->find($id);

        return $this->responseJson(
            $result->toArray()
        );
    }

    /**
     * @Route("/orthos/financeiro/fornecedor/save")
     */
    public function saveAction () {
        try {
            $form = $this->getRequestJson();
            $isEdit = FALSE;

            if (isset($form['sq_fornecedor'])) {
                $isEdit = TRUE;
            }

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sq_fornecedor']);
                $entity->setObject($form);
            } else {
                $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor($form);
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

    /**
     * @Route("/orthos/financeiro/fornecedor/remover/{id}")
     */
    public function removerAction ($id) {
        try {
            /** @var $entity \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor */
            $entity = $this->getBusiness()->find($id);
            $entity->setFlAtivo(FALSE);

            $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Fornecedor removido com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/financeiro/fornecedor/autocomplete")
     */
    public function autocompleteAction()
    {
        $post = $this->getRequestJson();

        $entity = new \Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor();
        $entity->setNoFornecedor($post['query']);

        $business = $this->getBusiness();
        $return = $business->getAutocomplete($entity);

        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/financeiro/fornecedor")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/financeiro/fornecedor/alterar/{id}")
     * @Template()
     */
    public function alterarAction($id)
    {
        $content = $this->renderView(
            'OrthosFinanceiroBundle:Fornecedor:cadastro.html.twig',
            array(
                'sqFornecedor' => $id
            )
        );

        return new \Symfony\Component\HttpFoundation\Response($content);
    }

    /**
     * @Route("/orthos/financeiro/fornecedor/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        return array(
            'sqFornecedor' => null
        );
    }
}
