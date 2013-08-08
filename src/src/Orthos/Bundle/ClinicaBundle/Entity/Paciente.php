<?php

namespace Orthos\Bundle\ClinicaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paciente
 *
 * @ORM\Table(name="tb_paciente")
 * @ORM\Entity
 */
class Paciente extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_paciente", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_paciente;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Paciente")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_indicacao", referencedColumnName="sq_paciente")
     * })
     */
    private $sq_indicacao;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Clinica")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_clinica", referencedColumnName="sq_clinica")
     * })
     */
    private $sq_clinica;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_paciente_status", referencedColumnName="sq_paciente_status")
     * })
     */
    private $sq_paciente_status;

    /**
     * @var  \Orthos\Bundle\ClinicaBundle\Entity\Convenio
     *
     * @ORM\ManyToOne(targetEntity="\Orthos\Bundle\ClinicaBundle\Entity\Convenio")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sq_convenio", referencedColumnName="sq_convenio")
     * })
     */
    private $sq_convenio;

    /**
     * @var string
     *
     * @ORM\Column(name="no_paciente", type="string", length=255)
     */
    private $no_paciente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_nascimento", type="date", nullable=true)
     */
    private $dt_nascimento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="date")
     */
    private $dt_cadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_sexo", type="string", length=1, nullable=true)
     */
    private $fl_sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_estado_civil", type="string", length=1, nullable=true)
     */
    private $fl_estado_civil;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_cpf", type="string", length=20, nullable=true)
     */
    private $nu_cpf;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_rg", type="integer", nullable=true)
     */
    private $nu_rg;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_orgao_expeditor", type="string", length=50, nullable=true)
     */
    private $ds_orgao_expeditor;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_cidade", type="string", length=255, nullable=true)
     */
    private $tx_cidade;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_uf", type="string", length=2, nullable=true)
     */
    private $tx_uf;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_endereco", type="string", length=255, nullable=true)
     */
    private $tx_endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_complemento", type="string", length=100, nullable=true)
     */
    private $tx_complemento;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_endereco", type="integer", nullable=true)
     */
    private $nu_endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_email", type="string", length=255, nullable=true)
     */
    private $ds_email;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_residencial", type="string", length=255, nullable=true)
     */
    private $nu_residencial;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_celular", type="string", length=20, nullable=true)
     */
    private $nu_celular;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_contato", type="string", length=1, nullable=true)
     */
    private $fl_contato;

    /**
     * @var string
     *
     * @ORM\Column(name="no_trabalho_empresa", type="string", length=255, nullable=true)
     */
    private $no_trabalho_empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_endereco_empresa", type="string", length=255, nullable=true)
     */
    private $tx_endereco_empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="no_profissao", type="string", length=255, nullable=true)
     */
    private $no_profissao;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_matricula", type="string", length=20)
     */
    private $nu_matricula;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_observacao", type="string", length=255, nullable=true)
     */
    private $tx_observacao;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_alerta_medico", type="string", length=255, nullable=true)
     */
    private $tx_alerta_medico;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_convenio", type="string", length=100, nullable=true)
     */
    private $tx_convenio;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_evolucao", type="string", length=255, nullable=true)
     */
    private $tx_evolucao;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_diagnostico", type="string", length=255, nullable=true)
     */
    private $tx_diagnostico;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_plano_tratamento", type="string", length=255, nullable=true)
     */
    private $tx_plano_tratamento;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_sequencia_mecanica", type="string", length=255, nullable=true)
     */
    private $tx_sequencia_mecanica;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_previsao", type="integer", nullable=true)
     */
    private $nu_previsao;

    /**
     * @var string
     *
     * @ORM\Column(name="fl_prognostico", type="string", length=2, nullable=true)
     */
    private $fl_prognostico;

    /**
     * @var string
     *
     * @ORM\Column(name="no_responsavel", type="string", length=255, nullable=true)
     */
    private $no_responsavel;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_cpf_responsavel", type="string", length=20, nullable=true)
     */
    private $nu_cpf_responsavel;

    /**
     * Get sq_paciente
     *
     * @return integer 
     */
    public function getSqPaciente()
    {
        return $this->sq_paciente;
    }

    /**
     * Set no_paciente
     *
     * @param string $noPaciente
     * @return Paciente
     */
    public function setNoPaciente($noPaciente)
    {
        $this->no_paciente = $noPaciente;
    
        return $this;
    }

    /**
     * Get no_paciente
     *
     * @return string 
     */
    public function getNoPaciente()
    {
        return $this->no_paciente;
    }

    /**
     * Set dt_nascimento
     *
     * @param \DateTime $dtNascimento
     * @return Paciente
     */
    public function setDtNascimento($dtNascimento)
    {
        $this->dt_nascimento = $dtNascimento;
    
        return $this;
    }

    /**
     * Get dt_nascimento
     *
     * @return \DateTime 
     */
    public function getDtNascimento()
    {
        return $this->dt_nascimento;
    }

    /**
     * Set fl_sexo
     *
     * @param string $flSexo
     * @return Paciente
     */
    public function setFlSexo($flSexo)
    {
        $this->fl_sexo = $flSexo;
    
        return $this;
    }

    /**
     * Get fl_sexo
     *
     * @return string 
     */
    public function getFlSexo()
    {
        return $this->fl_sexo;
    }

    /**
     * Set fl_estado_civil
     *
     * @param string $flEstadoCivil
     * @return Paciente
     */
    public function setFlEstadoCivil($flEstadoCivil)
    {
        $this->fl_estado_civil = $flEstadoCivil;
    
        return $this;
    }

    /**
     * Get fl_estado_civil
     *
     * @return string 
     */
    public function getFlEstadoCivil()
    {
        return $this->fl_estado_civil;
    }

    /**
     * Set nu_cpf
     *
     * @param integer $nuCpf
     * @return Paciente
     */
    public function setNuCpf($nuCpf)
    {
        $this->nu_cpf = $nuCpf;
    
        return $this;
    }

    /**
     * Get nu_cpf
     *
     * @return integer 
     */
    public function getNuCpf()
    {
        return $this->nu_cpf;
    }

    /**
     * Set nu_rg
     *
     * @param integer $nuRg
     * @return Paciente
     */
    public function setNuRg($nuRg)
    {
        $this->nu_rg = $nuRg;
    
        return $this;
    }

    /**
     * Get nu_rg
     *
     * @return integer 
     */
    public function getNuRg()
    {
        return $this->nu_rg;
    }

    /**
     * Set ds_orgao_expeditor
     *
     * @param string $dsOrgaoExpeditor
     * @return Paciente
     */
    public function setDsOrgaoExpeditor($dsOrgaoExpeditor)
    {
        $this->ds_orgao_expeditor = $dsOrgaoExpeditor;
    
        return $this;
    }

    /**
     * Get ds_orgao_expeditor
     *
     * @return string 
     */
    public function getDsOrgaoExpeditor()
    {
        return $this->ds_orgao_expeditor;
    }

    /**
     * Set tx_endereco
     *
     * @param string $txEndereco
     * @return Paciente
     */
    public function setTxEndereco($txEndereco)
    {
        $this->tx_endereco = $txEndereco;
    
        return $this;
    }

    /**
     * Get tx_endereco
     *
     * @return string 
     */
    public function getTxEndereco()
    {
        return $this->tx_endereco;
    }

    /**
     * Set tx_complemento
     *
     * @param string $txComplemento
     * @return Paciente
     */
    public function setTxComplemento($txComplemento)
    {
        $this->tx_complemento = $txComplemento;
    
        return $this;
    }

    /**
     * Get tx_complemento
     *
     * @return string 
     */
    public function getTxComplemento()
    {
        return $this->tx_complemento;
    }

    /**
     * Set nu_endereco
     *
     * @param integer $nuEndereco
     * @return Paciente
     */
    public function setNuEndereco($nuEndereco)
    {
        $this->nu_endereco = $nuEndereco;
    
        return $this;
    }

    /**
     * Get nu_endereco
     *
     * @return integer 
     */
    public function getNuEndereco()
    {
        return $this->nu_endereco;
    }

    /**
     * Set ds_email
     *
     * @param string $dsEmail
     * @return Paciente
     */
    public function setDsEmail($dsEmail)
    {
        $this->ds_email = $dsEmail;
    
        return $this;
    }

    /**
     * Get ds_email
     *
     * @return string 
     */
    public function getDsEmail()
    {
        return $this->ds_email;
    }

    /**
     * Set nu_residencial
     *
     * @param string $nuResidencial
     * @return Paciente
     */
    public function setNuResidencial($nuResidencial)
    {
        $this->nu_residencial = $nuResidencial;
    
        return $this;
    }

    /**
     * Get nu_residencial
     *
     * @return string 
     */
    public function getNuResidencial()
    {
        return $this->nu_residencial;
    }

    /**
     * Set nu_celular
     *
     * @param string $nuCelular
     * @return Paciente
     */
    public function setNuCelular($nuCelular)
    {
        $this->nu_celular = $nuCelular;
    
        return $this;
    }

    /**
     * Get nu_celular
     *
     * @return string 
     */
    public function getNuCelular()
    {
        return $this->nu_celular;
    }

    /**
     * Set fl_contato
     *
     * @param string $flContato
     * @return Paciente
     */
    public function setFlContato($flContato)
    {
        $this->fl_contato = $flContato;
    
        return $this;
    }

    /**
     * Get fl_contato
     *
     * @return string 
     */
    public function getFlContato()
    {
        return $this->fl_contato;
    }

    /**
     * Set no_trabalho_empresa
     *
     * @param string $noTrabalhoEmpresa
     * @return Paciente
     */
    public function setNoTrabalhoEmpresa($noTrabalhoEmpresa)
    {
        $this->no_trabalho_empresa = $noTrabalhoEmpresa;
    
        return $this;
    }

    /**
     * Get no_trabalho_empresa
     *
     * @return string 
     */
    public function getNoTrabalhoEmpresa()
    {
        return $this->no_trabalho_empresa;
    }

    /**
     * Set tx_endereco_empresa
     *
     * @param string $txEnderecoEmpresa
     * @return Paciente
     */
    public function setTxEnderecoEmpresa($txEnderecoEmpresa)
    {
        $this->tx_endereco_empresa = $txEnderecoEmpresa;
    
        return $this;
    }

    /**
     * Get tx_endereco_empresa
     *
     * @return string 
     */
    public function getTxEnderecoEmpresa()
    {
        return $this->tx_endereco_empresa;
    }

    /**
     * Set no_profissao
     *
     * @param string $noProfissao
     * @return Paciente
     */
    public function setNoProfissao($noProfissao)
    {
        $this->no_profissao = $noProfissao;
    
        return $this;
    }

    /**
     * Get no_profissao
     *
     * @return string 
     */
    public function getNoProfissao()
    {
        return $this->no_profissao;
    }

    /**
     * Set nu_matricula
     *
     * @param integer $nuMatricula
     * @return Paciente
     */
    public function setNuMatricula($nuMatricula)
    {
        $this->nu_matricula = $nuMatricula;
    
        return $this;
    }

    /**
     * Get nu_matricula
     *
     * @return integer 
     */
    public function getNuMatricula()
    {
        return $this->nu_matricula;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Clinica $sq_clinica
     */
    public function setSqClinica ($sq_clinica)
    {
        $this->sq_clinica = $sq_clinica;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Clinica
     */
    public function getSqClinica ()
    {
        return $this->sq_clinica;
    }

    /**
     * @param int $sq_paciente
     */
    public function setSqPaciente ($sq_paciente)
    {
        $this->sq_paciente = $sq_paciente;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Paciente $sq_indicacao
     */
    public function setSqIndicacao ($sq_indicacao)
    {
        $this->sq_indicacao = $sq_indicacao;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Paciente
     */
    public function getSqIndicacao ()
    {
        return $this->sq_indicacao;
    }

    /**
     * @param \DateTime $dt_cadastro
     */
    public function setDtCadastro ($dt_cadastro)
    {
        $this->dt_cadastro = $dt_cadastro;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro ()
    {
        return $this->dt_cadastro;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus $sq_paciente_status
     */
    public function setSqPacienteStatus ($sq_paciente_status)
    {
        $this->sq_paciente_status = $sq_paciente_status;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\PacienteStatus
     */
    public function getSqPacienteStatus ()
    {
        return $this->sq_paciente_status;
    }

    /**
     * @param string $tx_cidade
     */
    public function setTxCidade ($tx_cidade)
    {
        $this->tx_cidade = $tx_cidade;
    }

    /**
     * @return string
     */
    public function getTxCidade ()
    {
        return $this->tx_cidade;
    }

    /**
     * @param string $tx_uf
     */
    public function setTxUf ($tx_uf)
    {
        $this->tx_uf = $tx_uf;
    }

    /**
     * @return string
     */
    public function getTxUf ()
    {
        return $this->tx_uf;
    }

    /**
     * @param \Orthos\Bundle\ClinicaBundle\Entity\Convenio $sq_convenio
     */
    public function setSqConvenio ($sq_convenio)
    {
        $this->sq_convenio = $sq_convenio;
    }

    /**
     * @return \Orthos\Bundle\ClinicaBundle\Entity\Convenio
     */
    public function getSqConvenio ()
    {
        return $this->sq_convenio;
    }

    /**
     * @param string $tx_observacao
     */
    public function setTxObservacao ($tx_observacao)
    {
        $this->tx_observacao = $tx_observacao;
    }

    /**
     * @return string
     */
    public function getTxObservacao ()
    {
        return $this->tx_observacao;
    }

    /**
     * @param string $nu_previsao
     */
    public function setNuPrevisao ($nu_previsao)
    {
        $this->nu_previsao = $nu_previsao;
    }

    /**
     * @return string
     */
    public function getNuPrevisao ()
    {
        return $this->nu_previsao;
    }

    /**
     * @param string $tx_alerta_medico
     */
    public function setTxAlertaMedico ($tx_alerta_medico)
    {
        $this->tx_alerta_medico = $tx_alerta_medico;
    }

    /**
     * @return string
     */
    public function getTxAlertaMedico ()
    {
        return $this->tx_alerta_medico;
    }

    /**
     * @param string $tx_convenio
     */
    public function setTxConvenio ($tx_convenio)
    {
        $this->tx_convenio = $tx_convenio;
    }

    /**
     * @return string
     */
    public function getTxConvenio ()
    {
        return $this->tx_convenio;
    }

    /**
     * @param string $tx_diagnostico
     */
    public function setTxDiagnostico ($tx_diagnostico)
    {
        $this->tx_diagnostico = $tx_diagnostico;
    }

    /**
     * @return string
     */
    public function getTxDiagnostico ()
    {
        return $this->tx_diagnostico;
    }

    /**
     * @param string $tx_plano_tratamento
     */
    public function setTxPlanoTratamento ($tx_plano_tratamento)
    {
        $this->tx_plano_tratamento = $tx_plano_tratamento;
    }

    /**
     * @return string
     */
    public function getTxPlanoTratamento ()
    {
        return $this->tx_plano_tratamento;
    }

    /**
     * @param string $tx_sequencia_mecanica
     */
    public function setTxSequenciaMecanica ($tx_sequencia_mecanica)
    {
        $this->tx_sequencia_mecanica = $tx_sequencia_mecanica;
    }

    /**
     * @return string
     */
    public function getTxSequenciaMecanica ()
    {
        return $this->tx_sequencia_mecanica;
    }

    /**
     * @param string $fl_prognostico
     */
    public function setFlPrognostico ($fl_prognostico)
    {
        $this->fl_prognostico = $fl_prognostico;
    }

    /**
     * @return string
     */
    public function getFlPrognostico ()
    {
        return $this->fl_prognostico;
    }

    /**
     * @param string $tx_evolucao
     */
    public function setTxEvolucao ($tx_evolucao)
    {
        $this->tx_evolucao = $tx_evolucao;
    }

    /**
     * @return string
     */
    public function getTxEvolucao ()
    {
        return $this->tx_evolucao;
    }

    /**
     * @param string $no_responsavel
     */
    public function setNoResponsavel ($no_responsavel)
    {
        $this->no_responsavel = $no_responsavel;
    }

    /**
     * @return string
     */
    public function getNoResponsavel ()
    {
        return $this->no_responsavel;
    }

    /**
     * @param string $nu_cpf_responsavel
     */
    public function setNuCpfResponsavel ($nu_cpf_responsavel)
    {
        $this->nu_cpf_responsavel = $nu_cpf_responsavel;
    }

    /**
     * @return string
     */
    public function getNuCpfResponsavel ()
    {
        return $this->nu_cpf_responsavel;
    }
}
