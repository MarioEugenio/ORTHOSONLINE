<?php
namespace Orthos\Bundle\NewslatterBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Parcelas;
use Orthos\Bundle\NewslatterBundle\Entity\NewslatterEnvio;

class NewslatterEnvioBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\NewslatterBundle\Model\NewslatterEnvioModel';

    public function save (NewslatterEnvio $entity) {
        $this->getModel()->save($entity);
    }
}
