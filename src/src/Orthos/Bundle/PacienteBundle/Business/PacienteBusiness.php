<?php
namespace Orthos\Bundle\PacienteBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus;

class PacienteBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\PacienteBundle\Model\PacienteModel';

    public function getPacienteNewsllater () {
        return $this->getModel()->getPacienteNewsllater();
    }

    public function relatorioPacienteInadimplenteStatus (PacienteStatus $entity) {
        $model = $this->getModel();
        $result = array ();
        $result['data'] = array ();
        $result['totalGeral'] = 0;

        $return = $model->getPacienteInadimplentePorStatus($entity);

        if ($return) {
            $i=1;
            $totalGeral = 0;
            /** @var $value Paciente */
            foreach ($return as $value) {
                /** @var $parcelas \Orthos\Bundle\FinanceiroBundle\Business\ParcelasBusiness */
                $parcelas = $this->callService('Orthos.ParcelasBusiness');

                $parcelasAtrasadas = $parcelas->getParcelasAtrasadasPorPaciente($value);
                $resParcelas = $this->_preparaParcelasAtrasadas($parcelasAtrasadas);

                $total = $this->_preparaParcelasTotal ($parcelasAtrasadas);

                $result['data'][] = array (
                    'numero' => str_pad($i,4,0,STR_PAD_LEFT),
                    'contrato' => $value->getNuMatricula(),
                    'nome' => $value->getNoPaciente(),
                    'telefone' => $value->getNuResidencial(),
                    'meses' => $resParcelas,
                    'total' => number_format($total,2,'.',',')
                );

                $totalGeral = $totalGeral + $total;
                $i++;
            }

            $result['totalGeral'] = $totalGeral;
        }

        return $result;
    }

    private function _preparaParcelasAtrasadas ($data) {
        $result = array ();
        if ($data) {
            /** @var $value \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
            foreach ($data as $value) {
                $result[] = $value->getDtVencimento()->format('m/Y');
            }
        }

        return implode(' ', $result);
    }

    private function _preparaParcelasTotal ($data) {
        $total = 0;
        if ($data) {
            /** @var $value \Orthos\Bundle\FinanceiroBundle\Entity\Parcelas */
            foreach ($data as $value) {
                $total = $total + $value->getVlParcela();
            }
        }

        return $total;
    }

    public function getPaciente (Paciente $entity) {
        $model = $this->getModel();
        return $model->getPaciente($entity);
    }

    public function getPacientePorNome (Paciente $entity) {
        $model = $this->getModel();
        return $model->getPacientePorNome($entity);
    }

    public function getAutocompletePacientePorNome (Paciente $entity) {
        $model = $this->getModel();

        $result = $model->getPacientePorNome($entity);
        $return = array();

        if ($result) {
            foreach ($result as $value) {
                $return[] = array(
                    'id' => $value->getSqPaciente() ,
                    'value' => $value->getNoPaciente()
                );
            }
        }

        return $return;
    }

    public function _save (Paciente $entity) {
        $this->_validaSave($entity);
        $model = $this->getModel();

        /** @var $user \Core\OrthosBundle\Entity\Usuario */
        $user = $this->getAuthenticate();

        $date = $this->getXysLibrary()->date()->convertDateTime($entity->getDtNascimento());

        $entity->setDtNascimento($date);
        $entity->setDtCadastro(new \DateTime());

        if (!$entity->getSqClinica()) {
            $matricula = $user->getSqClinica()->getSqClinica() . $model->getMaxMatricula();
            $entity->setNuMatricula($matricula);
        }

        $entity->setSqClinica(
            $user->getSqClinica()
        );

        if ($entity->getSqPaciente()) {
            $model->update($entity);
        } else {
            $model->save($entity);
        }

    }

    private function _validaSave (Paciente $entity) {

        if (!$entity->getNoPaciente()) {
            $this->addMessage('O campo Nome é de preenchimento obrigatório');
        }

        if (!$entity->getDtNascimento()) {
            $this->addMessage('O campo Data de Nascimento é de preenchimento obrigatório');
        }

        if (!$entity->getFlSexo()) {
            $this->addMessage('O campo Sexo é de preenchimento obrigatório');
        }

        if (!$entity->getFlEstadoCivil()) {
            $this->addMessage('O campo Estado Civil é de preenchimento obrigatório');
        }

        if (!$entity->getTxEndereco()) {
            $this->addMessage('O campo Endereço é de preenchimento obrigatório');
        }

        if (!$entity->getNuEndereco()) {
            $this->addMessage('O campo Número é de preenchimento obrigatório');
        }

        if (!$entity->getNuResidencial()) {
            $this->addMessage('O campo Telefone Residêncial é de preenchimento obrigatório');
        }

        $this->exceptionMessages();
    }
}
