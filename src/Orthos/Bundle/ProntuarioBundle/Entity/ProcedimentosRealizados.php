<?php

namespace Orthos\Bundle\ProntuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcedimentosRealizados
 *
 * @ORM\Table(name="tb_preocedimentos_realizados")
 * @ORM\Entity
 */
class ProcedimentosRealizados extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_procedimentos_realizados", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_procedimentos_realizados;

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
     * Get sq_procedimentos_realizados
     *
     * @return integer 
     */
    public function getSqProcedimentosRealizados()
    {
        return $this->sq_procedimentos_realizados;
    }

    /**
     * Set sq_procedimento
     *
     * @param \Orthos\Bundle\ProntuarioBundle\Entity\Procedimento $sqProcedimento
     * @return ProcedimentosRealizados
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
     * @return ProcedimentosRealizados
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
