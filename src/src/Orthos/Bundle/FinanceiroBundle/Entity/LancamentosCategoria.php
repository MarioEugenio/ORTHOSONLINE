<?php

namespace Orthos\Bundle\FinanceiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LancamentosCategoria
 *
 * @ORM\Table(name="tb_lancamentos_categoria")
 * @ORM\Entity
 */
class LancamentosCategoria extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_lancamentos_categoria", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_lancamentos_categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="no_categoria", type="string", length=100)
     */
    private $no_categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_categoria", type="string", length=255)
     */
    private $ds_categoria;


    /**
     * Get sq_lancamentos_categoria
     *
     * @return integer 
     */
    public function getSqLancamentosCategoria()
    {
        return $this->sq_lancamentos_categoria;
    }

    /**
     * Set no_categoria
     *
     * @param string $noCategoria
     * @return LancamentosCategoria
     */
    public function setNoCategoria($noCategoria)
    {
        $this->no_categoria = $noCategoria;
    
        return $this;
    }

    /**
     * Get no_categoria
     *
     * @return string 
     */
    public function getNoCategoria()
    {
        return $this->no_categoria;
    }

    /**
     * Set ds_categoria
     *
     * @param string $dsCategoria
     * @return LancamentosCategoria
     */
    public function setDsCategoria($dsCategoria)
    {
        $this->ds_categoria = $dsCategoria;
    
        return $this;
    }

    /**
     * Get ds_categoria
     *
     * @return string 
     */
    public function getDsCategoria()
    {
        return $this->ds_categoria;
    }
}
