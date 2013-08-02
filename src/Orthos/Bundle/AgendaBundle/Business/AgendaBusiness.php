<?php
namespace Orthos\Bundle\AgendaBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;

class AgendaBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\AgendaBundle\Model\AgendaModel';

    public function getAgendaPorPaciente (Paciente $entity) {
        $model = $this->getModel();
        return $model->getAgendaPorPaciente ($entity);
    }

    public function getAgendaProntuario (Paciente $entity) {
        $model = $this->getModel();
        $return = array ();
        $result = $model->getAgendaProntuario ($entity);

        if ($result) {
            /** @var $value \Orthos\Bundle\AgendaBundle\Entity\Agenda */
            foreach ($result as $value) {
                $return[] = array (
                    'sq_agenda' => $value->getSqAgenda(),
                    'dt_inicio' => $value->getDtInicio()->format('d/m/Y H:i'),
                    'dt_fim' => $value->getDtFim()->format('d/m/Y H:i'),
                    'tx_observacao' => $value->getTxObservacao()
                );
            }
        }

        return $return;
    }

    public function listStatusAgenda ($data, $clinica) {
        $list = array ();

        $agendaEntity = new \Orthos\Bundle\AgendaBundle\Entity\Agenda();
        $agendaEntity->setDtInicio($this->getXysLibrary()->date()->convertDateTime($data));
        $agendaEntity->setDtFim($this->getXysLibrary()->date()->convertDateTime($data));
        $agendaEntity->getDtInicio()->setTime(00,00,00);
        $agendaEntity->getDtFim()->setTime(23,59,59);
        $agendaEntity->setSqClinica(
            $this->callService('Orthos.ClinicaBusiness')->find($clinica)
        );

        $result = $this->getModel()->getPacientePorDataObject($agendaEntity);

        if ($result) {
            /** @var $value \Orthos\Bundle\AgendaBundle\Entity\Agenda */
            foreach ($result as $value) {
                $list[] = array(
                    'numero' => ($value->getSqCadeira())? $value->getSqCadeira()->getNoCadeira() : null,
                    'map' => $value->getNuRow().'|'.$value->getNuColunm(),
                    'sqCadeira' => ($value->getSqCadeira())? $value->getSqCadeira()->getSqCadeira(): null,
                    'tx_observacao' => \nl2br($value->getTxObservacao()),
                    'status' => $value->getSqStatus()->getDsCorStatus(),
                    'sqAgenda' => $value->getSqAgenda(),
                    'dtChegada' => ($value->getDtChegada())? $value->getDtChegada()->format('H:i'):null,
                    'sq_atendente' => ($value->getSqAtendente())? $value->getSqAtendente()->getSqUsuario():null,
                    'no_atendente' => ($value->getSqAtendente())? $value->getSqAtendente()->getNoUsuario():null,
                    'sq_dentista' => ($value->getSqMedico())? $value->getSqMedico()->getSqUsuario():null,
                    'no_dentista' => ($value->getSqMedico())? $value->getSqMedico()->getNoUsuario():null,
                    'paciente' => array(
                        'nome' => ($value->getSqPaciente())? $value->getSqPaciente()->getNoPaciente():$value->getNoPaciente(),
                        'id'   => ($value->getSqPaciente())? $value->getSqPaciente()->getSqPaciente():null,
                        'matricula'   => ($value->getSqPaciente())? $value->getSqPaciente()->getNuMatricula():null,
                        'telefone' => $value->getNuPaciente()
                    ));
            }
        }

        return $list;
    }

    public function listGridAgenda (Paciente $entity) {
        $model = $this->getModel();
        $list = array ();

        $result = $model->getAgendaPorPaciente ($entity);

        if ($result) {
            /** @var $value \Orthos\Bundle\AgendaBundle\Entity\Agenda */
            foreach ($result as $value) {
                $list[] = array (
                    'dtAgenda' => $value->getDtInicio()->format('d/m/Y H:i'),
                    'dtChegada' => ($value->getDtChegada())? $value->getDtChegada()->format('d/m/Y H:i'): null,
                    'noAtendente' =>  null,
                    'txObservacao' => $value->getTxObservacao(),
                    'status' => $value->getSqStatus()->getNoStatus()
                );
            }
        }

        return $list;
    }

    public function _save (\Orthos\Bundle\AgendaBundle\Entity\Agenda $entity) {
        $model = $this->getModel();

        $clinica = $this->getClinica();

        $entity->setSqClinica($clinica);

        if ($entity->getSqAgenda()) {
            $model->update($entity);
        } else {
            $model->save($entity);
        }
    }

    public function getPacientePorData ($date) {
        $agendaEntity = new \Orthos\Bundle\AgendaBundle\Entity\Agenda();
        $agendaEntity->setDtInicio($this->getXysLibrary()->date()->convertDateTime($date));
        $agendaEntity->setDtFim($this->getXysLibrary()->date()->convertDateTime($date));
        $agendaEntity->getDtInicio()->setTime(00,00,00);
        $agendaEntity->getDtFim()->setTime(23,59,59);

        return $this->getModel()->getPacientePorData($agendaEntity);
    }

    public function getAgenda ($date, $clinica=NULL) {
        $model = $this->getModel();
        /** @var $user \Core\OrthosBundle\Entity\Usuario */
        $user = $this->getAuthenticate();

        /** @var $clinicaEntity \Orthos\Bundle\ClinicaBundle\Entity\Clinica */
        if ($clinica) {
            $clinicaEntity = $this->callService('Orthos.ClinicaBusiness')->find($clinica);
        } else {
            $clinicaEntity = $user->getSqClinica();
        }

        $cadeiraBs = $this->callService('Orthos.CadeiraBusiness');
        $arrObjCadeira = $cadeiraBs->findBy(TRUE,array('sq_clinica' => $clinicaEntity, 'fl_ativo' => TRUE));

        $result = array();
        $i=8;

        $intervalo = $clinicaEntity->getNuIntervalo();

        if ($intervalo == 0) $intervalo = 1;

        if ($intervalo) {
            $divIntervalo = (60 / $intervalo);
        }

        for ($i; $i <= 19; $i++) {
            for ($min=1;$min<=$intervalo;$min++) {
                $agendaEntity = new \Orthos\Bundle\AgendaBundle\Entity\Agenda();
                $agendaEntity->setDtInicio($this->getXysLibrary()->date()->convertDateTime($date));
                $agendaEntity->setDtFim($this->getXysLibrary()->date()->convertDateTime($date));
                $agendaEntity->getDtInicio()->setTime($i,00,00);
                $agendaEntity->getDtFim()->setTime($i,30,00);

                if ($clinica) {
                    $agendaEntity->setSqClinica($this->callService('Orthos.ClinicaBusiness')->find($clinica));
                }

                $indice = $i.'_'.$min;

                if ($min==1) {
                    $result[$indice] = array (
                        'idTime' => $i,
                        'date' => $date,
                        'time' => $i.":00/".$i.":".$divIntervalo
                    );
                } else {

                    $minInt = ($divIntervalo * $min);
                    if ($minInt == 60) $minInt = 59;

                    $result[$indice] = array (
                        'idTime' => $i,
                        'date' => $date,
                        'time' => $i.":".(($divIntervalo * $min) - $divIntervalo)."/".$i.":".$minInt
                    );
                }


                if ($arrObjCadeira) {
                    foreach($arrObjCadeira as $objCadeira) {
                        $agendaEntity->setSqCadeira($objCadeira);



                        $result[$indice]['cadeiras'][] = array(
                                                      'numero' => $objCadeira->getNoCadeira(),
                                                      'sqCadeira' => $objCadeira->getSqCadeira(),
                                                      'tx_observacao' => ((isset($agendaResult[0]))?$agendaResult[0]->getTxObservacao():''),
                                                      'status' => ((isset($agendaResult[0]))?$agendaResult[0]->getSqStatus()->getDsCorStatus():''),
                                                      'sqAgenda' => ((isset($agendaResult[0]))?$agendaResult[0]->getSqAgenda():null),
                                                      'dtChegada' => NULL,
                                                      'sq_atendente' => NULL,
                                                       'no_atendente' => NULL,
                                                        'sq_dentista' => NULL,
                                                        'no_dentista' => NULL,
                                                        'paciente' => array(
                                                          'nome' => ((isset($agendaResult[0]))?$agendaResult[0]->getNoPaciente():''),
                                                          'id'   => NULL,
                                                          'matricula'   => NULL
                                                      ));
                    }
                }
          }
        }
        return $result;
    }

}
