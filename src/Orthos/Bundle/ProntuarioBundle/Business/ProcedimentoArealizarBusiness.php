<?php
namespace Orthos\Bundle\ProntuarioBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\ProntuarioBundle\Entity\ProcedimentosARealizar;

class ProcedimentoArealizarBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\ProntuarioBundle\Model\ProcedimentoArealizarModel';

    public function save (ProcedimentosARealizar $entity) {
        $model = $this->getModel();
        $model->save($entity);
    }
}
