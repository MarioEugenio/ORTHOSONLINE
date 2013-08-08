<?php

namespace Core\OrthosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends \abstraction\controller\AbstractController
{
    const EMAIL_RECEBIMENTO = "mario.eugenio@gmail.com";

    /**
     * @Route("/login", name="root")
     * @Template()
     */
    public function indexAction()
    {
        apc_clear_cache();
        apc_clear_cache('user');
        apc_clear_cache('opcode');

        if ($this->isAuthenticated()) {
            return $this->redirect($this->generateUrl('main'));
        }

        return array();
    }

    /**
     * @Route("/contato")
     * @Template()
     */
    public function contatoAction () {
        return array();
    }

    /**
     * @Route("/contato/enviarContato")
     */
    public function enviarContatoAction () {
        $form = $this->getRequestJson();

        $date = new \DateTime();

        $mensagem = "<strong>Usuário:</strong> " . $this->getAuthenticate()->getNoUsuario() . "<br>"
                  . "<strong>Clínica:</strong> " . $this->getAuthenticate()->getSqClinica()->getNoClinica() . "<br>"
                  . "<strong>Data/Horário:</strong> " . $date->format('d/m/Y H:i') . "<br>"
                  . "<hr>"
                  . "<strong>Mensagem:</strong> " . $form['mensagem'];

        $message = \Swift_Message::newInstance()
            ->setSubject("Orthos Online Suporte: " . $form['assunto'])
            ->setFrom($this->getAuthenticate()->getDsEmail())
            ->setTo(self::EMAIL_RECEBIMENTO)
            ->setBody($mensagem,
                      'text/html');

        $this->get('mailer')->send($message);

        return $this->responseMessage('Mensagem enviada com sucesso', TRUE);
    }

    /**
     * @Route("/accessDenied", name="accessDenied")
     * @Template()
     */
    public function accessDeniedAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/inicial")
     * @Template()
     */
    public function inicialAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/main", name="main")
     * @Template()
     */
    public function mainAction()
    {

        /** @var $user \Core\OrthosBundle\Entity\Usuario */
        $user = $this->getAuthenticate();

        return array(
            'clinica' => $this->getClinica()->toJson(),
            'user' => $user->toJson()
        );
    }
}
