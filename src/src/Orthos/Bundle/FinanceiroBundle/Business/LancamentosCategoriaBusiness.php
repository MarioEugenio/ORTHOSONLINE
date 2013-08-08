<?php
namespace Orthos\Bundle\FinanceiroBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\FinanceiroBundle\Entity\Financeiro;
use Orthos\Bundle\FinanceiroBundle\Entity\Fornecedor;

class LancamentosCategoriaBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\FinanceiroBundle\Model\LancamentosCategoriaModel';
}
