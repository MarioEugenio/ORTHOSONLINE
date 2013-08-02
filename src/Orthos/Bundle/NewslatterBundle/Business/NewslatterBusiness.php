<?php
namespace Orthos\Bundle\NewslatterBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\NewslatterBundle\Entity\Newslatter;

class NewslatterBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\NewslatterBundle\Model\NewslatterModel';

    public function save (Newslatter $entity, Array $arrEnvio=NULL)
    {
        try {
            $this->_validate($entity);

            $entity->setDtCadastro(new \DateTime());

            $this->getModel()->save($entity);

            if ($arrEnvio) {
                foreach ($arrEnvio as $value) {
                    $envio = new \Orthos\Bundle\NewslatterBundle\Entity\NewslatterEnvio();
                    $envio->setFlEnvio(FALSE);
                    $envio->setNoDestinatario($value['noDestinatario']);
                    $envio->setTxEmail($value['txEmail']);
                    $envio->setSqNewslatter($entity);

                    $this->callService('Orthos.NewslatterEnvioBusiness')->save($envio);
                }
            }

            $this->commit();
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            $this->rollback();
            throw $exc;
        } catch (\abstraction\model\exception\ExceptionModel $exc) {
            $this->rollback();
            throw $exc;
        }
    }

    private function _validate (Newslatter $entity) {

        if (!$entity->getNoNewslatter()) {
            $this->addMessage('O campo Nome Newslatter é obrigatório');
        }

        if (!$entity->getSqModeloDocumento()) {
            $this->addMessage('Selecione o modelo de documento');
        }

        $this->exceptionMessages();
    }
}
