<?php
/**
 * Classe Abstrata para Persist
 *
 * @package abstraction\persist
 * @name AbstractModel
 * @author Mário Eugênio <mario.oliveira@xys.com.br>
 * @version 0.0.1
 */
namespace abstraction\persist;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractPersist
{
    protected $_container;

    /**
     * string de repositório
     * @var string
     */
    protected $_repository;

    /**
     * Conexão de banco
     * @var string
     */
    protected $_entityManager = 'default';
    /**
     * instância do doctrine
     * @var object|string
     */
    protected $instance;

    /**
     * resultado para consulta
     * @var array|string|object
     */
    public $result;

    /**
     * instância doctrine
     *
     * @param object|string $instance
     */
    public function setDoctrine ($instance)
    {
        $this->instance = $instance;
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine ()
    {
        return $this->instance;
    }

    /**
     * Retorna Entity Manager
     *
     * @return EntityManager
     */
    public function getEntityManager ()
    {
        return $this->getDoctrine()->getEntityManager($this->_entityManager);
    }

    /**
     * Retorna Repositório
     * @return EntityRepository
     */
    public function getRepository ()
    {
        return $this->getEntityManager()->getRepository($this->_repository);
    }

    /**
     * Consulta Simples FindAll
     *
     * @param boolean $isObject
     *
     * @return array|arrayCollection
     */
    public function findAll ($isObject = TRUE)
    {
        $result = $this->getRepository()->findAll();

        if ($isObject) {
            return $result;
        }

        if (count($result) > 0) {
            $return = array();
            foreach ($result as $res) {
                $return[] = $this->objectToArray($res);
            }
            return $return;
        }
        return;
    }

    /**
     * Consulta simples por array de parametros
     *
     * @param boolean $isObject
     * @param array $fields
     *
     * @return object|array
     */
    public function findBy ($isObject = TRUE, array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
    {
        $result = $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);

        if ($isObject) {
            return $result;
        }

        $return = array();
        foreach ($result as $res) {
            $return[] = $this->objectToArray($res);
        }
        return $return;
    }

    /**
     * Consulta simples por chave
     *
     * @param integer $id
     * @param boolean $isObject
     *
     * @return object|array
     */
    public function find ($id, $isObject = TRUE)
    {
        $result = $this->getRepository()->find($id);
        if ($isObject) {
            return $result;
        }
        return $this->objectToArray($result);
    }

    /**
     * método responsável por realizar consulta segundo comando DQL
     *
     * @param string $dql
     * @param array $param
     * @param boolean $isObject
     * @param boolean $getSQL
     *
     * @return array|Doctrine\ORM\EntityRepository
     */
    public function select ($dql, $param = array(), $isObject = TRUE, $getSQL = FALSE, $maxResults = FALSE, $offset = FALSE)
    {
        try {
            if (TRUE == $getSQL) {
                var_dump($this->getEntityManager()->createQuery($dql)->getSQL());
                exit;
            } else {
                if ($maxResults) {
                    $this->result = $this->getEntityManager()->createQuery($dql)->setMaxResults($maxResults);
                    if ($offset) {
                        $this->result = $this->result->setFirstResult($offset);
                    }
                } else {
                    $this->result = $this->getEntityManager()->createQuery($dql);
                }
                if ($param) {
                    foreach ($param as $key => $value) {
                        $this->result->setParameter($key, $value);
                    }
                }

                if ($isObject) {
                    return $this->result->getResult();
                } else {
                    return $this->result->getArrayResult();
                }
            }
        } catch (\abstraction\persist\exception\ExceptionPersist $exc) {
            throw $exc;
        }
    }

    public function execute ($dql,Array $param=NULL)
    {
        try {
            $em = $this->getEntityManager();

            $result = $em->createQuery($dql);

            if ($param) {
                foreach ($param as $key => $value) {
                    $result->setParameter($key, $value);
                }
            }

            return $result->execute();
        } catch (\abstraction\persist\exception\ExceptionPersist $exc) {
            throw $exc;
        } catch (\PDOException $exc) {
            throw new \abstraction\persist\exception\ExceptionPersist($exc->getMessage());
        }
    }

    /**
     * método responsável por realizar consulta segundo comando SQL NATIVE
     *
     * @param string $dql
     * @param ResultSetMapping $mapper
     * @param array $param
     *
     * @return array|Doctrine\ORM\EntityRepository
     */
    public function sqlNative ($sql, ResultSetMapping $mapper, Array $param = NULL)
    {
        try {
            $this->result = $this->getEntityManager()->createNativeQuery($sql, $mapper);

            if ($param) {
                foreach ($param as $key => $value) {
                    $this->result->setParameter($key, $value);
                }
            }

            $this->getEntityManager()->close();

            return $this->result->getArrayResult();
        } catch (\abstraction\persist\exception\ExceptionPersist $exc) {
            throw $exc;
        }
    }

    /**
     * método para cadastro de registro
     *
     * @param \abstraction\entity\AbstractEntity $entity
     *
     * @return \abstraction\entity\AbstractEntity
     * @throws ExceptionPersist
     */
    public function save (\abstraction\entity\AbstractEntity $entity)
    {
        try {

            $em = $this->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        } catch (\PDOException $exc) {
            throw new \abstraction\model\exception\ExceptionModel($exc->getMessage());
        }
    }

    /**
     * método para alteração de registro
     *
     * @param \abstraction\entity\AbstractEntity $entity
     *
     * @return \abstraction\entity\AbstractEntity
     * @throws ExceptionPersist
     * @throws exception\ExceptionPersist
     */
    public function update (\abstraction\entity\AbstractEntity $entity)
    {
        try {
            $em = $this->getEntityManager();

            if (!$entity) {
                throw new exception\ExceptionPersist('Unable to find entity.');
            }

            $em->merge($entity);
            $em->flush();

            $this->result = $entity;
            return $entity;
        } catch (\abstractLayer\persist\exception\ExceptionPersist $exc) {
            throw $exc;
        }
    }

    /**
     * método para remoção de registro
     *
     * @param integer $id
     *
     * @return object
     * @throws ExceptionPersist
     * @throws exception\ExceptionPersist
     */
    public function delete ($id)
    {
        try {
            $entity = $this->find($id);
            $em = $this->getEntityManager();

            if (!$entity) {
                throw new exception\ExceptionPersist('Unable to find entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->result = $entity;

            return $entity;
        } catch (\abstractLayer\persist\exception\ExceptionPersist $exc) {
            throw $exc;
        }
    }

    private function _checkEntityManager ()
    {
        $em = $this->getEntityManager();
        if (!$em->isOpen())
            $this->getEntityManager();
    }

    /**
     * método para conversão de objeto para array
     *
     * @param object $object
     *
     * @return array
     */
    private function objectToArray ($object)
    {
        if (is_object($object)) {

            $className = get_class($object);
            $methods = get_class_methods($className);
            $arr = array();
            foreach ($methods as $value) {

                if ('get' == substr($value, 0, 3)) {
                    $var = lcfirst(str_replace('get', '', $value));
                    $val = $object->$value();

                    if ($val instanceof \DateTime) {
                        $val = date('d/m/Y H:i:s', $val->getTimestamp());
                    }

                    if (!is_object($val)) {
                        $arr[$var] = $val;
                    }
                }
            }

            return $arr;
        }
    }
}
