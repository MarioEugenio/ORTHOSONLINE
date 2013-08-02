<?php

namespace Orthos\Bundle\ProntuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProntuarioController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\ProntuarioBundle\Business\ProntuarioBusiness';


    /**
     * @Route("/orthos/prontuario/cadastro/{paciente}")
     * @Template()
     */
    public function cadastroAction($paciente)
    {
        $consultas = $this->get('Orthos.AgendaBusiness')->getAgendaProntuario(
            $this->get('Orthos.PacienteBusiness')->find($paciente)
        );

        return array(
            'sqPaciente' => $paciente,
            'consultas' => json_encode($consultas)
        );
    }

    /**
     * @Route("/orthos/prontuario/list/{id}")
     */
    public function prontuarioAction($id)
    {
        $business = $this->get('Orthos.PacienteBusiness');

        $form = $this->getRequestJson();
        $entity = new \Orthos\Bundle\ProntuarioBundle\Entity\Prontuario($form);
        $entity->setSqPaciente(
            $business->find($id)
        );

        $result = $this->get('Orthos.ProntuarioBusiness')->listMaxProntuario($entity);

        return  $this->responseJson($result);
    }

    /**
     * @Route("/orthos/prontuario/save")
     */
    public function salvarAction ()
    {
        try {
            $form = $this->getRequestJson();

            $paciente = $this->get('Orthos.PacienteBusiness');

            $entity = new \Orthos\Bundle\ProntuarioBundle\Entity\Prontuario();
            $entity->setSqPaciente(
                $paciente->find($form['sqPaciente'])
            );

            if (isset ($form['txObservacao'])) {
                $entity->setTxObservacao($form['txObservacao']);
            }


            if (isset ($form['sq_agenda'])) {
                /** @var $agenda \Orthos\Bundle\AgendaBundle\Entity\Agenda */
                $agenda = $this->get('Orthos.AgendaBusiness')->find($form['sq_agenda']);
                $entity->setSqAgenda($agenda);

                $thd = array();

                if ($agenda->getSqAtendente()){
                    $atendente = $this->get('CoreUser.UserBusiness')->find($agenda->getSqAtendente()->getSqUsuario());

                    if ($atendente) {
                        $thd['thd'] = $atendente->toArray();
                    }
                }


                $agenda->setSqStatus(
                    $this->get('Orthos.StatusBusiness')->find(4)
                );

                $this->getBusiness()->getModel()->getEntityManager()->persist($agenda);
                $this->getBusiness()->getModel()->getEntityManager()->flush();
            }

            $business = $this->getBusiness();
            $business->save($entity, $form);

            $result = $entity->toArray();
            $result = $business->getAuthenticate()->toArray() + $thd + $result;
           return $this->responseMessage(
                'Cadastro realizado com sucesso',
                TRUE,
                array_merge($result, $form)
            );
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage(
                $exc->getMessage(),
                FALSE
            );
        } catch (\Exception $exc ) {
            return $this->responseMessage(
                $exc->getMessage(),
                FALSE
            );
        }
    }
}
