<?php
namespace Orthos\Bundle\ProntuarioBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ProntuarioBundle\Entity\ProcedimentosRealizados;

class ProcedimentoRealizadosBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ProntuarioBundle\Model\ProcedimentoRealizadosModel';

    public function save (ProcedimentosRealizados $entity) {
        $model = $this->getModel();
        $model->save($entity);
    }
}
