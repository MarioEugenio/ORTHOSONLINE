<?php

namespace Orthos\Bundle\ProntuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcedimentosARealizar
 *
 * @ORM\Table(name="tb_procedimentos_arealizar")
 * @ORM\Entity
 */
class ProcedimentosARealizar extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_procedimentos_arealizar", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_procedimentos_arealizar;

    /**
     * @var  \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ProntuarioBundle\Entity\Procedimento")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_procedimento", referencedColumnName="sq_procedimento")
     * })
     */
    private $sq_procedimento;

    /**
     * @var  \Orthos\Bundle\ProntuarioBundle\Entity\Prontuario
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ProntuarioBundle\Entity\Prontuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_prontuario", referencedColumnName="sq_prontuario")
     * })
     */
    private $sq_prontuario;


    /**
     * Get sq_procedimentos_arealizar
     *
     * @return integer 
     */
    public function getSqProcedimentosArealizar()
    {
        return $this->sq_procedimentos_arealizar;
    }

    /**
     * Set sq_procedimento
     *
     * @param \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento $sqProcedimento
     * @return ProcedimentosARealizar
     */
    public function setSqProcedimento(\Orthos\Bundle\ProntuarioBundle\Entity\Procedimento $sqProcedimento)
    {
        $this->sq_procedimento = $sqProcedimento;
    
        return $this;
    }

    /**
     * Get sq_procedimento
     *
     * @return \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento
     */
    public function getSqProcedimento()
    {
        return $this->sq_procedimento;
    }

    /**
     * Set sq_prontuario
     *
     * @param \Orthos\Bundle\ProntuarioBundle\Entity\Prontuario $sqProntuario
     * @return ProcedimentosARealizar
     */
    public function setSqProntuario(\Orthos\Bundle\ProntuarioBundle\Entity\Prontuario $sqProntuario)
    {
        $this->sq_prontuario = $sqProntuario;
    
        return $this;
    }

    /**
     * Get sq_prontuario
     *
     * @return \Orthos\Bundle\ProntuarioBundle\Entity\Prontuario
     */
    public function getSqProntuario()
    {
        return $this->sq_prontuario;
    }
}
