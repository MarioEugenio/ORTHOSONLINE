<?php

namespace Orthos\Bundle\AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AgendaController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\AgendaBundle\Business\AgendaBusiness';

    /**
     * @Route("/orthos/agenda/save")
     */
    public function saveAction()
    {
        try {

            $form = $this->getRequestJson();

            $isEdit = FALSE;
            if (isset($form['sqAgenda'])) {
                $isEdit = TRUE;
            }

            $cadeiraBs = $this->get('Orthos.CadeiraBusiness');
            $cadeiraEntity = $cadeiraBs->find($form['sq_cadeira']);

            $usuarioEntity = null;
            if (isset($form['sq_atendente'])) {
                $usuarioBs = $this->get('CoreUser.UserBusiness');
                $usuarioEntity = $usuarioBs->find($form['sq_atendente']);
            }

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sqAgenda']);
                $entity->setObject($form);
            } else {
                $entity = new \Orthos\Bundle\AgendaBundle\Entity\Agenda($form);
            }


            if (isset ($form['sq_paciente'])) {
                $pacienteBs = $this->get('Orthos.PacienteBusiness');
                $pacienteEntity = $pacienteBs->find($form['sq_paciente']);
                $entity->setSqPaciente($pacienteEntity);
            }

            $time = explode('/',$form['time']);

            if (isset($form['sq_dentista'])) {
                $usuarioBs = $this->get('CoreUser.UserBusiness');
                $entity->setSqMedico(
                    $usuarioBs->find($form['sq_dentista'])
                );
            }


            $entity->setSqAtendente($usuarioEntity);

            $entity->setDtCadastro(new \DateTime());
            $entity->setSqCadeira($cadeiraEntity);
            $entity->setSqStatus(
                $this->get('Orthos.StatusBusiness')->find(1)
            );

            $entity->setDtInicio($this->getXysLibrary()->date()->convertDateTime($form['date']));
            $entity->setDtFim($this->getXysLibrary()->date()->convertDateTime($form['date']));


            $hours = explode(':',$time[0]);
            $entity->getDtInicio()->setTime($hours[0],$hours[1],00);
            $hours = explode(':',$time[1]);
            $entity->getDtFim()->setTime($hours[0],$hours[1],00);

            $business = $this->getBusiness();
            $business->_save($entity);

            $paciente = ($entity->getSqPaciente())? $entity->getSqPaciente()->toArray() : null;

            if ($isEdit) {
                return $this->responseMessage("Alteração realizada com sucesso", TRUE, $entity->toArray() + array('paciente' => $paciente) + $entity->getSqStatus()->toArray());
            }

            return $this->responseMessage("Agendamento realizado com sucesso", TRUE, $entity->toArray() + array('paciente' => $paciente) + $entity->getSqStatus()->toArray());
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        } catch (\Exception $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/agenda/checkStatus")
     */
    public function checkStatusAgenda () {
        $form = $this->getRequestJson();
        $result = $this->getBusiness()->listStatusAgenda($form['date'], $form['clinica']);
        $arrResult = array();

        if ($result) {
            $arrResult = $result;
        }

        return $this->responseJson($arrResult);
    }

    /**
     * @Route("/orthos/agenda/status/{sqAgenda}/{sqStatus}")
     */
    public function statusAction ($sqAgenda, $sqStatus) {
        try {
            /** @var $entity \Orthos\Bundle\AgendaBundle\Entity\Agenda */
            $entity = $this->getBusiness()->find($sqAgenda);
            $entity->setSqStatus(
                $this->get('Orthos.StatusBusiness')->find($sqStatus)
            );

            if ($sqStatus == 2) {
                $entity->setDtChegada(new \DateTime());
            }

            $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Processo realizado com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/agenda/load")
     */
    public function loadAction()
    {
        $form = $this->getRequestJson();
        $business = $this->getBusiness();

        $clinica = (isset($form['clinica']))? $form['clinica'] : null;

        $return = $business->getAgenda($form['date'], $clinica);

        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/agenda/remover")
     */
    public function removerAction()
    {
        try {
            $form = $this->getRequestJson();

            /** @var $entity \Orthos\Bundle\AgendaBundle\Entity\Agenda */
            $entity = $this->getBusiness()->find($form['sqAgenda']);
            $entity->setSqStatus(
                $this->get('Orthos.StatusBusiness')->find(3)
            );
            $entity->setSqUsuarioFinaliza($this->getAuthenticate());
            $entity->setFlFinalizado(TRUE);

            $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Agendamento removido com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }
}
