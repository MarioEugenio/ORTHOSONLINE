<?php
namespace Orthos\Bundle\ProntuarioBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ProntuarioBundle\Entity\Prontuario;

class ProntuarioBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ProntuarioBundle\Model\ProntuarioModel';

    public function listProntuario (Prontuario $entity) {
        $result = $this->getModel()->listProntuario($entity);
        $arrResult = array ();

        if ($result) {
            $realizado = $this->callService('Orthos.ProcedimentoRealizadosBusiness');
            $arealizar = $this->callService('Orthos.ProcedimentoArealizarBusiness');

            /** @var $value Prontuario */
            foreach ($result as $value) {
                $realizadoResult = array();
                $arealizarResult = array();

                if ((!$value->getDsProntuarioArealizar()) && (!$value->getDsProntuarioRealizado())) {
                    $realizadoResult = $this->_formatProcedimentos($realizado->findBy(TRUE, array('sq_prontuario' => $value->getSqProntuario())));
                    $arealizarResult = $this->_formatProcedimentos($arealizar->findBy(TRUE, array('sq_prontuario' => $value->getSqProntuario())));
                } else {
                    $realiz = array();
                    $realiz[] = array('noProcedimento' => $value->getDsProntuarioRealizado());
                    $realizadoResult = $realiz;
                    $arealiz = array();
                    $arealiz[] = array('noProcedimento' => $value->getDsProntuarioArealizar());
                    $arealizarResult = $arealiz;
                }


                $atendente = NULL;

                if ($value->getSqAgenda()) {
                    if ($value->getSqAgenda()->getSqAtendente()) {
                        if ($value->getSqAgenda()->getSqAtendente()->getSqUsuario()) {
                            $user = $value->getSqAgenda()->getSqAtendente()->getSqUsuario();
                            $entityUser = $this->callService('CoreUser.UserBusiness')->find($user);
                            $atendente = $entityUser->getNoUsuario();

                        }
                    }
                }

                $arrResult[] = array (
                    'dt_procedimento' => $value->getDtProcedimento()->format('d/m/Y')
                    ,'no_usuario' => $value->getSqUsuario()->getNoUsuario()
                    ,'no_atendente' => $atendente
                    ,'realizados' => $realizadoResult
                    ,'arealizar' => $arealizarResult
                    ,'txObservacao' => $value->getTxObservacao()
                );
            }
        }

        return $arrResult;
    }

    public function listMaxProntuario (Prontuario $entity) {
        $result = $this->getModel()->listMaxProntuario($entity);
        $arrResult = array ();

        if ($result) {
            $realizado = $this->callService('Orthos.ProcedimentoRealizadosBusiness');
            $arealizar = $this->callService('Orthos.ProcedimentoArealizarBusiness');

            /** @var $value Prontuario */
            foreach ($result as $value) {
                $realizadoResult = array();
                $arealizarResult = array();

                if ((!$value->getDsProntuarioArealizar()) && (!$value->getDsProntuarioRealizado())) {
                    $realizadoResult = $this->_formatProcedimentos($realizado->findBy(TRUE, array('sq_prontuario' => $value->getSqProntuario())));
                    $arealizarResult = $this->_formatProcedimentos($arealizar->findBy(TRUE, array('sq_prontuario' => $value->getSqProntuario())));
                } else {
                    $realiz = array();
                    $realiz[] = array('noProcedimento' => $value->getDsProntuarioRealizado());
                    $realizadoResult = $realiz;
                    $arealiz = array();
                    $arealiz[] = array('noProcedimento' => $value->getDsProntuarioArealizar());
                    $arealizarResult = $arealiz;
                }

                $arrResult[] = array (
                    'dt_procedimento' => $value->getDtProcedimento()->format('d/m/Y')
                    ,'no_usuario' => $value->getSqUsuario()->getNoUsuario()
                    ,'realizados' => $realizadoResult
                    ,'arealizar' => $arealizarResult
                    ,'txObservacao' => $value->getTxObservacao()
                );
            }
        }

        return $arrResult;
    }

    private function _formatProcedimentos ($result) {
        $arrResult = array ();
        if ($result) {

            foreach ($result as $value) {
                $arrResult[] = array (
                    'noProcedimento' => ($value->getSqProcedimento())? $value->getSqProcedimento()->getNoProcedimento(): NULL
                );
            }
        }

        return $arrResult;
    }

    public function save (Prontuario $entity, Array $arrCollection=NULL) {
        $this->beginTransaction();

        try {
            $this->_validateSave($arrCollection);

            $entity->setDtProcedimento(new \DateTime());
            $entity->setSqUsuario($this->getAuthenticate());

            $business = $this->getModel();
            $business->save($entity);

            $this->_procedimentosRealizados($entity, $arrCollection);
            $this->_procedimentosARealizar($entity, $arrCollection);

            $this->commit();

        } catch (\abstraction\model\exception\ExceptionModel $exc) {
            $this->rollback();

            throw new \abstraction\business\exception\ExceptionBusiness(
                'Ocorreu um erro inesperado ao realizar esse processo, tente novamente'
            );
        }
    }

    private function _validateSave (Array $arrCollection=NULL) {
        if ((!isset($arrCollection['realizados'])) && (!isset($arrCollection['arealizar']))) {
            $this->addMessage('Selecione pelo menos um item para cadastrar prontuário');
        }

        $this->exceptionMessages();
    }

    private function _procedimentosRealizados (Prontuario $entity, Array $arrCollection=NULL) {
        /** @var $business ProcedimentoRealizadosBusiness */
        $business = $this->callService('Orthos.ProcedimentoRealizadosBusiness');
        /** @var $procedimento ProcedimentoBusiness */
        $procedimento = $this->callService('Orthos.ProcedimentoBusiness');

        if (isset($arrCollection['realizados'])) {
            foreach ($arrCollection['realizados'] as $value) {
                $procedimentoEntity = $procedimento->find($value['sqProcedimento']);
                $realizados = new \Orthos\Bundle\ProntuarioBundle\Entity\ProcedimentosRealizados();
                $realizados->setSqProntuario($entity);
                $realizados->setSqProcedimento($procedimentoEntity);

                $business->save($realizados);
            }
        }
    }

    private function _procedimentosARealizar (Prontuario $entity, Array $arrCollection=NULL) {
        /** @var $business ProcedimentoArealizarBusiness */
        $business = $this->callService('Orthos.ProcedimentoArealizarBusiness');

        /** @var $procedimento ProcedimentoBusiness */
        $procedimento = $this->callService('Orthos.ProcedimentoBusiness');

        if (isset($arrCollection['arealizar'])) {
            foreach ($arrCollection['arealizar'] as $value) {
                $procedimentoEntity = $procedimento->find($value['sqProcedimento']);
                $arealizar = new \Orthos\Bundle\ProntuarioBundle\Entity\ProcedimentosARealizar();
                $arealizar->setSqProntuario($entity);
                $arealizar->setSqProcedimento($procedimentoEntity);

                $business->save($arealizar);
            }
        }
    }
}
