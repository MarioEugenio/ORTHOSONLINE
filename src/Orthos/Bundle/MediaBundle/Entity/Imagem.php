<?php

namespace Orthos\Bundle\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imagem
 *
 * @ORM\Table(name="tb_imagem")
 * @ORM\Entity
 */
class Imagem extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_imagem", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_imagem;

    /**
     * @var string
     *
     * @ORM\Column(name="no_arquivo", type="string", length=400)
     */
    private $no_arquivo;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_arquivo", type="string", length=400, nullable=true)
     */
    private $ds_arquivo;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Paciente")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_paciente", referencedColumnName="sq_paciente")
     * })
     */
    private $sq_paciente;

    /**
     * @var  \Core\OrthosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Core\OrthosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_usuario", referencedColumnName="sq_usuario")
     * })
     */
    private $sq_usuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime")
     */
    private $dt_cadastro;

    private $dt_inicial;

    private $dt_final;


    /**
     * Get sq_imagem
     *
     * @return integer 
     */
    public function getSqImagem()
    {
        return $this->sq_imagem;
    }

    /**
     * Set no_arquivo
     *
     * @param string $noArquivo
     * @return Imagem
     */
    public function setNoArquivo($noArquivo)
    {
        $this->no_arquivo = $noArquivo;
    
        return $this;
    }

    /**
     * Get no_arquivo
     *
     * @return string 
     */
    public function getNoArquivo()
    {
        return $this->no_arquivo;
    }

    /**
     * Set ds_arquivo
     *
     * @param string $dsArquivo
     * @return Imagem
     */
    public function setDsArquivo($dsArquivo)
    {
        $this->ds_arquivo = $dsArquivo;
    
        return $this;
    }

    /**
     * Get ds_arquivo
     *
     * @return string 
     */
    public function getDsArquivo()
    {
        return $this->ds_arquivo;
    }

    /**
     * Set sq_usuario
     *
     * @param \Core\OrthosBundle\Entity\Usuario $sqUsuario
     * @return Imagem
     */
    public function setSqUsuario(\Core\OrthosBundle\Entity\Usuario $sqUsuario)
    {
        $this->sq_usuario = $sqUsuario;
    
        return $this;
    }

    /**
     * Get sq_usuario
     *
     * @return \Core\OrthosBundle\Entity\Usuario
     */
    public function getSqUsuario()
    {
        return $this->sq_usuario;
    }

    /**
     * Set dt_cadastro
     *
     * @param \DateTime $dtCadastro
     * @return Imagem
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dt_cadastro = $dtCadastro;
    
        return $this;
    }

    /**
     * Get dt_cadastro
     *
     * @return \DateTime 
     */
    public function getDtCadastro()
    {
        return $this->dt_cadastro;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Paciente $sq_paciente
     */
    public function setSqPaciente ($sq_paciente)
    {
        $this->sq_paciente = $sq_paciente;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     */
    public function getSqPaciente ()
    {
        return $this->sq_paciente;
    }

    public function setDtFinal ($dt_final)
    {
        $this->dt_final = $dt_final;
    }

    public function getDtFinal ()
    {
        return $this->dt_final;
    }

    public function setDtInicial ($dt_inicial)
    {
        $this->dt_inicial = $dt_inicial;
    }

    public function getDtInicial ()
    {
        return $this->dt_inicial;
    }
}
