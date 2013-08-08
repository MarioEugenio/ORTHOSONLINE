<?php
namespace Orthos\Bundle\FinanceiroBundle\Model;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Lancamentos;

class LancamentosCategoriaModel extends \abstraction\model\AbstractModel
{
    protected $repository = 'OrthosFinanceiroBundle:LancamentosCategoria';
}
