<?php
namespace Orthos\Bundle\ProntuarioBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ProntuarioBundle\Entity\Procedimento;

class ProcedimentoBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ProntuarioBundle\Model\ProcedimentoModel';

    public function getProcedimento (Procedimento $entity) {
        return $this->getModel()->getProcedimento($entity);
    }

    public function save (Procedimento $entity) {

        $entity->setVlProcedimento(
            $this->prepareMoney($entity->getVlProcedimento())
        );

        $this->getModel()->save($entity);
    }

    public function autocomplete (Procedimento $entity) {
        $result = $this->getModel()->getProcedimento($entity);
        $arrResult = array ();

        if ($result) {
            foreach ($result as $value) {
                $arrResult[] = array (
                    'id' => $value->getSqProcedimento(),
                    'value' => $value->getNoProcedimento()
                );
            }
        }

        return $arrResult;
    }
}
