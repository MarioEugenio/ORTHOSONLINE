<?php

namespace Core\OrthosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UsuarioController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Core\OrthosBundle\Business\UsuarioBusiness';

    /**
     * @Route("/usuario")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/usuario/remover/{id}")
     */
    public function removerAction ($id) {

    }

    /**
     * @Route("/usuario/logoff")
     */
    public function logoffAction () {
        $this->get('security.context')->setToken(NULL);
        $this->getBusiness()->getSession()->invalidate();
        $this->getBusiness()->getSession()->clear();
        $this->getBusiness()->getSession()->clearFlashes();

        return $this->redirect($this->generateUrl('root'));
    }

    /**
     * @Route("/usuario/alterarSenha")
     * @Template()
     */
    public function alterarSenhaAction () {
        return array();
    }

    /**
     * @Route("/usuario/saveSenha")
     */
    public function saveSenhaAction () {
        try {


            $form = $this->getRequestJson();
            $user = $this->getAuthenticate();
            $user->setTxSenha(md5($form['tx_senha']));

            $this->getBusiness()->getModel()->getEntityManager()->persist($user);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Senha alterada com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/usuario/definirClinica")
     */
    public function definirClinicaAction () {
        try {

            $form = $this->getRequestJson();

            if (!$form['sqClinica']) {
                throw new \abstraction\business\exception\ExceptionBusiness(
                    'Defina a clinica que deseja logar'
                );
            }

            $this->getSession()->set('clinica',
                $this->get('Orthos.ClinicaBusiness')->find($form['sqClinica'])->toArray()
            );

            return $this->responseMessage('Usuário autenticado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/usuario/autenticar")
     */
    public function autenticarAction () {
        try {

            $form = $this->getRequestJson();

            $user = $form['user'];
            $password = $form['password'];

            $entity = new \Core\OrthosBundle\Entity\Usuario();
            $entity->setDsEmail($user);
            $entity->setTxSenha(md5($password));

            $this->getBusiness()->autenticar($entity);

            $clinicas['clinicas'] = $this->getBusiness()->autenticar($entity);

            return $this->responseMessage('Usuário autenticado com sucesso', TRUE, $clinicas);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/usuario/alterar/{id}")
     * @Template()
     */
    public function alterarAction($id)
    {
        $perfil = $this->getBusiness(
            '\Core\OrthosBundle\Business\PerfilBusiness'
        );

        $business = $this->getBusiness();

        $clinica = $this->get(
            'Orthos.ClinicaBusiness'
        );

        $content = $this->renderView(
            'CoreOrthosBundle:Usuario:cadastro.html.twig',
            array(
                'usuario' => json_encode($business->getUsuarioPerfil($business->find($id))),
                'listPerfil' => json_encode($perfil->findAll(FALSE)),
                'listClinica' => json_encode($clinica->findAll(FALSE))
            )
        );

        return new \Symfony\Component\HttpFoundation\Response($content);
    }

    /**
     * @Route("/usuario/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        $perfil = $this->getBusiness(
            '\Core\OrthosBundle\Business\PerfilBusiness'
        );

        $clinica = $this->get(
            'Orthos.ClinicaBusiness'
        );

        return array(
            'usuario' => "",
            'listPerfil' => json_encode($perfil->findAll(FALSE)),
            'listClinica' => json_encode($clinica->findAll(FALSE))
        );
    }

    /**
     * @Route("/usuario/save")
     */
    public function saveAction()
    {
        try {
            $form = $this->getRequestJson();

            $isEdit = FALSE;

            if (isset($form['sq_usuario'])) {
                $isEdit = TRUE;
            }

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sq_usuario']);
                $entity->setObject($form);
            } else {
                $entity = new \Core\OrthosBundle\Entity\Usuario($form);
                $entity->setFlAtivo(TRUE);
            }

            if (isset($form['sqClinicas'])) {
                $clinicas = $entity->getClinicas();

                if ($clinicas) {
                    foreach ($clinicas as $item) {
                        $entity->getClinicas()->removeElement($item);
                        $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
                        $this->getBusiness()->getModel()->getEntityManager()->flush();
                    }
                }
                foreach ($form['sqClinicas'] as $value) {
                    $entity->getClinicas()->add($this->get('Orthos.ClinicaBusiness')->find($value));
                }
            }

            if (isset($form['sqPerfil'])) {
                $perfis = $entity->getPerfis();

                if ($perfis) {
                    foreach ($perfis as $item) {
                        $entity->getPerfis()->removeElement($item);
                        $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
                        $this->getBusiness()->getModel()->getEntityManager()->flush();
                    }
                }
                foreach ($form['sqPerfil'] as $value) {
                    $entity->getPerfis()->add($this->get('Core.PerfilBusiness')->find($value));
                }
            }

            $business = $this->getBusiness();
            $business->_save($entity);

            if ($isEdit) {
                return $this->responseMessage("Alteração realizada com sucesso", TRUE);
            }

            return $this->responseMessage("Cadastro realizado com sucesso", TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        } catch (\Exception $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/usuario/search")
     */
    public function searchAction()
    {
        $business = $this->getBusiness();

        $form = $this->getRequestJson();
        $entity = new \Core\OrthosBundle\Entity\Usuario($form);

        $result = $business->getUsuario($entity);
        $retorno = array ();
        if ($result) {
            foreach ($result as $value) {
                $retorno[] = $value->toArray();
            }
        }

        return $this->responseJson($retorno);
    }

    /**
     * @Route("/orthos/usuario/atendente")
     */
    public function atendenteAction()
    {
        $post = $this->getRequestJson();

        $usuario = new \Core\OrthosBundle\Entity\Usuario();
        $usuario->setNoUsuario($post['query']);

        /** @var $business \Core\OrthosBundle\Business\UsuarioBusiness */
        $business = $this->getBusiness();
        $return = $business->getAutocompleteAtendentePorNome($usuario);

        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/usuario/medico")
     */
    public function medicoAction()
    {
        $post = $this->getRequestJson();

        $usuario = new \Core\OrthosBundle\Entity\Usuario();
        $usuario->setNoUsuario($post['query']);

        /** @var $business \Core\OrthosBundle\Business\UsuarioBusiness */
        $business = $this->getBusiness();
        $return = $business->getAutocompleteMedicoPorNome($usuario);

        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/usuario/search/{id}")
     */
    public function getAtendentePorIdAction($id)
    {
        /** @var $business  \Core\OrthosBundle\Business\UsuarioBusiness*/
        $business = $this->getBusiness();
        $return = $business->find($id, FALSE);

        return $this->responseJson($return);
    }

    /**
     * @Route("/usuario/deletar/{id}")
     */
    public function deletarAction($id)
    {
        try {
            $business = $this->getBusiness();
            $business->delete($id);

            return $this->responseMessage("Registro removido com sucesso", TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        } catch (\Exception $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/usuario/getMenuPerfil")
     */
    public function getPerfilMenusAction () {
        $user = $this->getAuthenticate();
        $perfis = $user->getPerfis();

        $arrMenus = array();

        if ($perfis) {
            foreach ($perfis as $value) {
                $menus = $value->getMenus();
                if ($menus) {
                    /** @var $item \Core\OrthosBundle\Entity\Menu */
                    foreach ($menus as $item) {
                        if (!$item->getSqMenuFilho()) {
                            $arrMenus[$item->getSqMenu()] = array(
                                'no_menu' => $item->getNoMenu(),
                                'ds_uri' => $item->getDsUri()
                            );
                        }
                    }

                    foreach ($menus as $item) {
                        if ($item->getSqMenuFilho()) {
                            $arrMenus[$item->getSqMenuFilho()->getSqMenu()]['filhos'][] = array(
                                'no_menu' => $item->getNoMenu(),
                                'ds_uri' => $item->getDsUri()
                            );
                        }
                    }
                }

            }
        }

        return $this->responseJson($arrMenus);
    }
}
