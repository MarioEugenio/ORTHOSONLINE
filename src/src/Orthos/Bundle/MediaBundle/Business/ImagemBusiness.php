<?php
namespace Orthos\Bundle\MediaBundle\Business;

use Orthos\Bundle\ClinicaBundle\Entity\Paciente;
use Orthos\Bundle\MediaBundle\Entity\Imagem;

class ImagemBusiness extends \abstraction\business\AbstractBusiness
{
    protected $model = '\Orthos\Bundle\MediaBundle\Model\ImagemModel';

    public function listImagem (Imagem $entity) {

        $result = $this->getModel()->listImagem($entity);
        $arrResult = array ();

        if ($result) {
            foreach ($result as $value) {
                $arrResult[] = array (
                 'dt_cadastro' => $value->getDtCadastro()->format('d/m/Y')
                ,'no_usuario' => ($value->getSqUsuario())? $value->getSqUsuario()->getNoUsuario():null
                ,'no_arquivo' => $value->getNoArquivo()
                ,'sq_imagem' => $value->getSqImagem()
                );
            }
        }

        return $arrResult;
    }

    public function save (\Orthos\Bundle\MediaBundle\Entity\Imagem $entity) {
        $model = $this->getModel();
        $model->save($entity);
    }
}
