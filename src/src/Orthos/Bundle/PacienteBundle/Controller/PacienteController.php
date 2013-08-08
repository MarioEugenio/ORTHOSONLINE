<?php

namespace Orthos\Bundle\PacienteBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Guzzle\Http\Client;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;

class PacienteController extends \abstraction\controller\AbstractController
{
    /**
     *
     * @var string
     */
    protected $business = '\Orthos\Bundle\PacienteBundle\Business\PacienteBusiness';

    /**
     * @Route("/orthos/paciente")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/orthos/paciente/listIndicacao/{paciente}")
     */
    public function listIndicacaoAction ($paciente) {
        $result = $this->getBusiness()->findBy(FALSE, array (
            'sq_paciente' => $this->get('Orthos.PacienteBusiness')->find($paciente)
        ));

        return $this->responseJson($result);
    }

    /**
     * @Route("/orthos/paciente/indicarPaciente")
     */
    public function indicarPacienteAction () {
        try {
            $form = $this->getRequestJson();
            $entity = new \Orthos\Bundle\ClinicaBundle\Entity\Paciente($form['indicacao']);
            $entity->setSqIndicacao(
                $this->getBusiness()->find($form['sqPaciente'])
            );

            $user = $this->getAuthenticate();
            $matricula = $user->getSqClinica()->getSqClinica() . $this->getBusiness()->getModel()->getMaxMatricula();
            $entity->setNuMatricula($matricula);
            $entity->setDtCadastro(new \DateTime());

            $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Indicação realizada com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/paciente/transferencia")
     * @Template()
     */
    public function transferenciaAction()
    {
        /** @var $clinica \Orthos\Bundle\ClinicaBundle\Business\ClinicaBusiness */
        $clinica = $this->get('Orthos.ClinicaBusiness');

        return array(
            'clinicas' => json_encode($clinica->findAll(FALSE))
        );
    }

    /**
     * @Route("/orthos/paciente/transferir/{paciente}/{clinica}")
     */
    public function transferirAction ($paciente, $clinica) {
        try {
            $clinica = $this->get('Orthos.ClinicaBusiness')->find($clinica);

            $paciente = $this->getBusiness()->find($paciente);
            $paciente->setSqClinica($clinica);

            $this->getBusiness()->getModel()->getEntityManager()->persist($paciente);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage('Paciente transferido com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/paciente/indicar")
     * @Template()
     */
    public function indicarAction()
    {
        /** @var $clinica \Orthos\Bundle\ClinicaBundle\Business\ClinicaBusiness */
        $clinica = $this->get('Orthos.ClinicaBusiness');

        return array(
            'clinicas' => json_encode($clinica->findAll(FALSE))
        );
    }

    /**
     * @Route("/orthos/paciente/enviarMensagem")
     * @Template()
     */
    public function enviarMensagemAction()
    {
        return array();
    }


    /**
     * @Route("/orthos/paciente/consultas/{id}")
     * @Template()
     */
    public function consultasAction($id)
    {
        $business = $this->get('Orthos.AgendaBusiness');

        $result = $business->listGridAgenda(
            $this->getBusiness()->find($id)
        );

        return  array(
            'listConsultas' => json_encode($result)
        );
    }

    /**
     * @Route("/orthos/paciente/consultasPesquisa/{id}")
     */
    public function consultasPesquisaAction($id)
    {
        $business = $this->get('Orthos.AgendaBusiness');

        $result = $business->listGridAgenda(
            $this->getBusiness()->find($id)
        );

        return  $this->responseJson(
            $result
        );
    }

    /**
     * @Route("/orthos/paciente/prontuario/{id}")
     * @Template()
     */
    public function prontuarioAction($id)
    {
        $business = $this->get('Orthos.PacienteBusiness');

        $form = $this->getRequestJson();
        $entity = new \Orthos\Bundle\ProntuarioBundle\Entity\Prontuario($form);
        $entity->setSqPaciente(
            $business->find($id)
        );

        $imagem = new \Orthos\Bundle\MediaBundle\Entity\Imagem($form);
        $imagem->setSqPaciente(
            $business->find($id)
        );

        $result = $this->get('Orthos.ProntuarioBusiness')->listProntuario($entity);
        $resultMedia = $this->get('Orthos.MediaBusiness')->listImagem($imagem);

        return  array(
            'listProntuario' => json_encode($result),
            'listProntuarioMedia' => json_encode($resultMedia)
        );
    }

    /**
     * @Route("/orthos/paciente/financeiro/{id}")
     * @Template()
     */
    public function financeiroAction($id)
    {
        $paciente = $this->get('Orthos.PacienteBusiness')->find($id);

        /** @var $business \Orthos\Bundle\FinanceiroBundle\Business\FinanceiroBusiness */
        $business = $this->get('Orthos.FinanceiroBusiness');
        $return = $business->getFinanceiroPorPaciente($paciente);

        return  array(
            'listFinanceiro' => json_encode($return)
        );
    }

    /**
     * @Route("/orthos/paciente/mensagens/{id}")
     * @Template()
     */
    public function mensagensAction($id)
    {
        $business = $this->get('Orthos.MensagemBusiness');

        $result = $business->findBy( FALSE,
            array('sq_paciente' => $this->getBusiness()->find($id))
        );

        return  array(
            'listMensagens' => json_encode($result)
        );
    }

    /**
     * @Route("/orthos/paciente/indicacao/{id}")
     * @Template()
     */
    public function indicacaoAction($id)
    {
        $business = $this->get('Orthos.PacienteBusiness');

        $result = $business->findBy( FALSE,
             array('sq_indicacao' => $this->getBusiness()->find($id))
        );

        return  array(
            'listIndicacao' => json_encode($result)
        );
    }

    /**
     * @Route("/orthos/paciente/find/{paciente}")
     * @ParamConverter("paciente", class="OrthosClinicaBundle:Paciente")
     */
    public function findAction (Paciente $paciente) {
        $arrPaciente = $paciente->toArray();
        $arrPaciente['sq_convenio'] = ($paciente->getSqConvenio())? $paciente->getSqConvenio()->getSqConvenio(): null;

        if ($paciente->getSqPacienteStatus()) {
            if ($paciente->getSqPacienteStatus()->getSqStatusFather()) {
                $arrPaciente['sq_paciente_status'] =  ($paciente->getSqPacienteStatus())? $paciente->getSqPacienteStatus()->getSqStatusFather()->getSqStatus(): null;
            } else {
                $arrPaciente['sq_paciente_status'] =  ($paciente->getSqPacienteStatus())? $paciente->getSqPacienteStatus()->getSqStatus(): null;
            }
        }

        return $this->responseJson($arrPaciente);
    }

    /**
     * @Route("/orthos/paciente/alteracao/{paciente}")
     * @ParamConverter("paciente", class="OrthosClinicaBundle:Paciente")
     * @Template()
     */
    public function alteracaoAction(Paciente $paciente)
    {
        /** @var $status \Orthos\Bundle\ClinicaBundle\Business\PacienteStatusBusiness */
        $status = $this->get('Orthos.PacienteStatusBusiness');

        $convenio = $this->get('Orthos.ConvenioBusiness');

        $arrPaciente = $paciente->toArray();
        $arrPaciente['sq_convenio'] = ($paciente->getSqConvenio())? $paciente->getSqConvenio()->getSqConvenio(): null;

        return array(
            'paciente' => json_encode($arrPaciente),
            'convenioPaciente' => NULL,
            'status' => json_encode($status->getAllPacienteStatus(FALSE)),
            'convenios' => json_encode($convenio->findAll(FALSE))
        );
    }

    /**
     * @Route("/orthos/paciente/cadastro")
     * @Template()
     */
    public function cadastroAction()
    {
        $convenio = $this->get('Orthos.ConvenioBusiness');

        return array(
            'convenios' => json_encode($convenio->findAll(FALSE))
        );
    }

    /**
     * @Route("/orthos/paciente/list")
     */
    public function searchAction()
    {
        $post = $this->getRequestJson();
        $paciente = new \Orthos\Bundle\ClinicaBundle\Entity\Paciente($post);

        /** @var $business \Orthos\Bundle\PacienteBundle\Business\PacienteBusiness */
        $business = $this->getBusiness();
        $return = $business->getPaciente($paciente);

        $list = array ();

        if ($return) {
            foreach($return as $value) {
                $list[] = $value->toArray();
            }
        }

        return $this->responseJson($list);
    }

    /**
     * @Route("/orthos/paciente/autocomplete")
     */
    public function autocompleteAction()
    {
        $post = $this->getRequestJson();

        $paciente = new \Orthos\Bundle\ClinicaBundle\Entity\Paciente();
        $paciente->setNoPaciente($post['query']);

        /** @var $business \Orthos\Bundle\PacienteBundle\Business\PacienteBusiness */
        $business = $this->getBusiness();
        $return = $business->getAutocompletePacientePorNome($paciente);

        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/paciente/search/{id}")
     */
    public function getPacientePorIdAction($id)
    {
        /** @var $business \Orthos\Bundle\PacienteBundle\Business\PacienteBusiness */
        $business = $this->getBusiness();
        $return = $business->find($id, FALSE);

        return $this->responseJson($return);
    }

    /**
     * @Route("/orthos/paciente/pagamentoCartao")
     * @Template()
     */
    public function pagarCartaoAction ()
    {
        // Create a client and provide a base URL
        $client = new Client('http://177.55.5.37:8080');

        $request = $client->post('WTS/service/Transaction', null, array(
            'CustomerKey' => '44f22df4-40a3-4ff2-9071-a824046f585a',
            'Operation' => 'Create',
            'Transaction' => array(
                'DueDate' => "",
                'TransactionOperation' => 'Credit',
                'InstallmentCount' => '',
                'AmountInCents' => '100',
                'Card' => array (
                    'CardBrand' => 'Visa',
                    'ExpMonth' => '05',
                    'ExpYear' => '2018',
                    'HolderName' => 'JACKSON V F SILVA',
                    'CardNumber' => '4012001037141112'
                )
            )
        ));

        $data = $request->send()->json();

        print_r($data); exit;

    }

    /**
     * @Route("/orthos/paciente/pagamento/{id}")
     * @Template()
     */
    public function pagamentoAction ($id) {
        $entity = $this->get('Orthos.ParcelasBusiness')->find($id, FALSE);

        return array(
            'parcela' => json_encode($entity)
        );
    }

    /**
     * @Route("/orthos/paciente/negociacao/{parcelas}")
     * @Template()
     */
    public function negociacaoAction ($parcelas) {
        $arrResult = array ();

        if ($parcelas) {
            $parcelas = explode(",",$parcelas);
            foreach ($parcelas as $value) {
                $entity = $this->get('Orthos.ParcelasBusiness')->find($value, FALSE);
                $arrResult[] = $entity;
            }
        }

        return array(
            'parcelas' => json_encode($arrResult)
        );
    }

    /**
     * @Route("/orthos/paciente/removerParcelas/{parcelas}")
     */
    public function removerParcelasAction ($parcelas) {
        try {
            if ($parcelas) {
                $parcelas = explode(",",$parcelas);
                foreach ($parcelas as $value) {
                    $entity = $this->get('Orthos.ParcelasBusiness')->find($value);

                    if ($entity) {
                        /** @var $business \Orthos\Bundle\FinanceiroBundle\Business\ParcelasBusiness */
                        $business = $this->get('Orthos.ParcelasBusiness');
                        $business->getModel()->getEntityManager()->remove($entity);
                        $business->getModel()->getEntityManager()->flush();
                    }
                }
            }

            return $this->responseMessage('Parcela(s) removidas com sucesso', TRUE);
        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/paciente/saveProntuario")
     */
    public function saveProntuarioAction()
    {
        try {
            $form = $this->getRequestJson();

            $entity = $this->getBusiness()->find($form['sq_paciente']);
            $entity->setObject($form);

            $this->getBusiness()->getModel()->getEntityManager()->persist($entity);
            $this->getBusiness()->getModel()->getEntityManager()->flush();

            return $this->responseMessage("Ação realizada com sucesso", TRUE);

        } catch (\abstraction\business\exception\ExceptionBusiness $exc) {
            return $this->responseMessage($exc->getMessage(), FALSE);
        }
    }

    /**
     * @Route("/orthos/paciente/save")
     */
    public function saveAction()
    {
        try {
            $form = $this->getRequestJson();

            $isEdit = FALSE;
            if (isset($form['sq_paciente'])) {
                $isEdit = TRUE;
            }

            if ($isEdit) {
                $entity = $this->getBusiness()->find($form['sq_paciente']);
                $entity->setObject($form);
            } else {
                $entity = new \Orthos\Bundle\ClinicaBundle\Entity\Paciente($form);
            }

            if (isset($form['sq_convenio'])) {
                $entity->setSqConvenio(
                    $this->get('Orthos.ConvenioBusiness')->find($form['sq_convenio'])
                );
            }

            if (isset($form['sq_paciente_status'])) {
                $entity->setSqPacienteStatus(
                    $this->get('Orthos.PacienteStatusBusiness')->find($form['sq_paciente_status'])
                );
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
}
