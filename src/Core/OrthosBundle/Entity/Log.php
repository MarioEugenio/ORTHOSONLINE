<?php

namespace Core\OrthosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="tb_log")
 * @ORM\Entity
 */
class Log extends \abstraction\entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sq_log", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sq_log;

    /**
     * @var array
     *
     * @ORM\Column(name="ob_entity", type="json_array", nullable=true)
     */
    private $ob_entity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime")
     */
    private $dt_cadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="tx_mensagem", type="string", length=255)
     */
    private $tx_mensagem;


    /**
     * Get sq_log
     *
     * @return integer 
     */
    public function getSqLog()
    {
        return $this->sq_log;
    }

    /**
     * Set ob_entity
     *
     * @param array $obEntity
     * @return Log
     */
    public function setObEntity($obEntity)
    {
        $this->ob_entity = $obEntity;
    
        return $this;
    }

    /**
     * Get ob_entity
     *
     * @return array 
     */
    public function getObEntity()
    {
        return $this->ob_entity;
    }

    /**
     * Set dt_cadastro
     *
     * @param \DateTime $dtCadastro
     * @return Log
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
     * Set tx_mensagem
     *
     * @param string $txMensagem
     * @return Log
     */
    public function setTxMensagem($txMensagem)
    {
        $this->tx_mensagem = $txMensagem;
    
        return $this;
    }

    /**
     * Get tx_mensagem
     *
     * @return string 
     */
    public function getTxMensagem()
    {
        return $this->tx_mensagem;
    }
}
