<?php
namespace Orthos\Bundle\MensagemBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\MensagemBundle\Entity\Mensagem;

class MensagemBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\MensagemBundle\Model\MensagemModel';

    const EMAIL_ENVIO = "mario.eugenio@gmail.com";

    public function save (Mensagem $entity) {
        $this->_validateSave($entity);

        $entity->setDtEnvio(new \DateTime());
        $entity->setFlEnviada(TRUE);

        $this->getModel()->save($entity);

        $this->enviarEmailPaciente($entity);
    }

    public function enviarEmailPaciente (Mensagem $entity) {
        $msg = "Caro sr(a): " . $entity->getSqPaciente()->getNoPaciente() . PHP_EOL
             . $entity->getTxMensagem();

        $message = \Swift_Message::newInstance()
            ->setSubject("Orthos Online: " . $entity->getTxAssunto())
            ->setFrom(self::EMAIL_ENVIO)
            ->setTo($entity->getSqPaciente()->getDsEmail())
            ->setBody($msg);

        $this->callService('mailer')->send($message);
    }

    private function _validateSave (Mensagem $entity) {
        if (!$entity->getFlTipoMensagem()) {
            $this->addMessage('O campo Tipo de Envio é de preenchimento obrigatório');
        }

        if (!$entity->getTxAssunto()) {
            $this->addMessage('O campo Assunto é de preenchimento obrigatório');
        }

        if (!$entity->getTxMensagem()) {
            $this->addMessage('O campo Mensagem é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}
