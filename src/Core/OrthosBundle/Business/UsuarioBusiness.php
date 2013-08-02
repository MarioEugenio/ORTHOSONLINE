<?php
namespace Core\OrthosBundle\Business;
use Core\OrthosBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UsuarioBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Core\OrthosBundle\Model\UsuarioModel';

    public function getUsuario (Usuario $entity) {
        $model = $this->getModel();
        return $model->getUsuario($entity);
    }

    public function getUsuarioPerfil (Usuario $entity) {
        $model = $this->getModel();
        $result = $model->getUsuario($entity);
        $retorno = null;

        if ($result) {
            /** @var $value Usuario */
            foreach ($result as $value) {
                $usuario = $value->toArray();

                if ($value->getPerfis()) {
                    foreach ($value->getPerfis() as $perf) {
                        $usuario['sqPerfil'][] = $perf->toArray();
                    }
                }

                if ($value->getClinicas()) {
                    foreach ($value->getClinicas() as $clinicas) {
                        $usuario['sqClinicas'][] = $clinicas->toArray();
                    }
                }

                $retorno = $usuario;
            }
        }

        return $retorno;
    }

    public function getAutocompleteMedicoPorNome (Usuario $entity) {
        $model = $this->getModel();

        $result = $model->getUsuarioMedico($entity);
        $return = array();

        if ($result) {
            foreach ($result as $value) {
                $return[] = array(
                    'id' => $value->getSqUsuario() ,
                    'value' => $value->getNoUsuario()
                );
            }
        }

        return $return;
    }

    public function getAutocompleteAtendentePorNome (Usuario $entity) {
        $model = $this->getModel();

        $result = $model->getUsuarioAtendente($entity);
        $return = array();

        if ($result) {
            foreach ($result as $value) {
                $return[] = array(
                    'id' => $value->getSqUsuario() ,
                    'value' => $value->getNoUsuario()
                );
            }
        }

        return $return;
    }

    public function autenticar (Usuario $entity) {
        if (!$entity->getDsEmail()) $this->addMessage('O campo Login/E-mail é obrigatório');

        if (!$entity->getTxSenha()) $this->addMessage('O campo Senha é obrigatório');

        $this->exceptionMessages();

        $result = $this->getModel()->findBy(TRUE, array (
            'ds_email' => $entity->getDsEmail(),
            'tx_senha' => $entity->getTxSenha()
        ));

        if ($result) {
            /** @var $user Usuario */
            $user = current($result);

            $userToken = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
                $user, NULL, 'main', array('ROLE_ADMIN')
            );
            $token = $this->container->get('security.context');
            $token->setToken($userToken);

            $this->getSession()->set('user', $user->getSqUsuario());

            return $this->_prepareClinicas($user);

        } else {
            $this->addMessage('Usuário não encontrado');
        }

        $this->exceptionMessages();
    }

    private function _prepareClinicas (Usuario $user) {
        $return = array ();
        if ($user->getClinicas()) {

            foreach ($user->getClinicas() as $value) {
                $return[] = $value->toArray();
            }
        }

        return $return;
    }

    public function _save (Usuario $entity) {
        $this->_validaSave($entity);
        $model = $this->getModel();

        if (!$entity->getSqUsuario()) {
            $password = md5($entity->getTxSenha());

            $entity->setTxSenha($password);
            $entity->setFlAtivo(TRUE);
            $entity->setSqClinica($this->getClinica());

            $model->save($entity);
        }

        $model->update($entity);
    }

    private function _validaSave (Usuario $entity) {
        if (!$entity->getSqUsuario()) {
            $result = $this->findBy(TRUE, array (
                'ds_email' => $entity->getDsEmail()
            ));

            if ($result) {
                $this->addMessage('E-mail ' . $entity->getDsEmail() . ' já existe cadastrado');
            }
        }

        if (!$entity->getNoUsuario()) {
            $this->addMessage('O campo nome é de preenchimento obrigatório');
        }

        if (!$entity->getDsEmail()) {
            $this->addMessage('O campo e-mail é de preenchimento obrigatório');
        }

        if (!$entity->getTxSenha()) {
            $this->addMessage('O campo senha é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}