<?php
/**
 * Classe Abstrata para Model
 *
 * @package abstraction\model
 * @name AbstractModel
 * @author Mário Eugênio <mario.oliveira@xys.com.br>
 * @version 0.0.1
 */
namespace abstraction\model;

use abstraction\persist\AbstractPersist;

abstract class AbstractModel extends AbstractPersist
{
    protected $repository;

    /**
     * Construtor Microblog para Model
     *
     * @param Doctrine $instance
     */
    public function __construct ($instance=NULL, $entityManager=NULL, $container=NULL)
    {
        $this->_entityManager = $entityManager;
        $this->_repository = $this->repository;
        $this->instance = $instance;
        $this->_container = $container;
    }

    public function setContainer ($container)
    {
        $this->_entityManager = $container->get('doctrine');
    }

    /**
     * @param null $namespace
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public function getSession ($namespace = NULL)
    {
        return $this->_container->get('request')->getSession();
    }

    /**
     * Retorna o usuário atualmente autenticado, ou gera uma exceção HTTP quando
     * não há um usuário ou a sessão expirou.
     * @return \Core\OrthosBundle\Entity\Usuario
     * @throws HttpException
     */
    public function getAuthenticate ()
    {
        $userData = $this->_container->get('CoreUser.UserBusiness')->find($this->getSession()->get('user'));

        return $userData;
    }

    public function getClinica () {
        if ($this->getSession()->get('clinica')) {
            $clinica = $this->getSession()->get('clinica');
            $entity = $this->_container->get('Orthos.ClinicaBusiness')->find($clinica['sq_clinica']);
            return $entity;
        }

        $user = $this->getAuthenticate();
        return $user->getSqClinica();
    }

    public function getPerfis () {
        $user = $this->getAuthenticate();
        return $user->getPerfis();
    }

    /**
     * Metodo responsavel por retornar os registros paginados utilizando o ZendDb
     *
     * @param $registersPerPage
     * @param $page
     * @param $dqlSelect
     * @param $resultCount
     *
     * @return array
     */
    protected function getResultPaginator($registersPerPage, $page, $dqlSelect, $resultCount, $dql = TRUE)
    {
        $currentIndex = $registersPerPage * $page - $registersPerPage;
        if($dql) {
            $query = $this->getEntityManager()->createQuery($dqlSelect);
            $query->setFirstResult($currentIndex);
            $query->setMaxResults($registersPerPage);
            $sql = $query->getSQL();
        } else {
            $dqlSelect .= " LIMIT " . $registersPerPage . " OFFSET " . $currentIndex;
            $sql = $dqlSelect;
        }

        $xysLibrary = new \abstraction\xysLibrary\XysLibrary();
        $data['content'] = $xysLibrary->externals()->zend()->db($this->getEntityManager())->fetchAll($sql);

        if($data['content']) {
            $data['content'] = $this->filterKeyResult($data['content']);
        }

        return $this->getInfoPaginator($data, $registersPerPage, $page, $resultCount);
    }

    public function getInfoPaginator($data, $registersPerPage, $page, $resultCount){
        $paginator = new \Core\PaginatorBundle\Business\PaginatorBusiness();
        $currentIndex = $registersPerPage * $page - $registersPerPage;

        $data['paginator']['totalRegisters'] = $resultCount;
        $data['paginator']['currentRegister'] = $currentIndex + 1;
        $data['paginator']['lastRegisterPage'] = $currentIndex + count($data['content']);

        $paginatorData = $paginator->paginator($data['paginator']['totalRegisters'],$page,$registersPerPage);

        $data['paginator']['totalRegisters'] = current($resultCount[0]);

        if($page == 1) {
            $data['paginator']['prevPage'] = FALSE;
        } else if($page > 1) {
            $data['paginator']['prevPage'] = $page - 1;
        }

        if($data['paginator']['totalRegisters'] > $paginatorData['final']) {
            $data['paginator']['nextPage'] = $page + 1;
        } else {
            $data['paginator']['nextPage'] = FALSE;
        }

        return $data;
    }

    public function filterKeyResult ($data) {
        $results = array();
        if ($data) {
            foreach ($data as $value) {
                $result = array();
                foreach ($value as $key =>$content) {
                    $identify = preg_replace('/[0-9]/','',$key);
                    if(array_key_exists($identify,$result)){
                        $identify .= '_second';
                    }
                    $result[$identify] = $content;
                }
                $results[] = $result;
            }
        }
        return $results;
    }
}
