<?php

namespace Core\MessageBundle\Tests\Unity\Business;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppKernel;
use appTestDebugProjectContainer;
use Core\MessageBundle\Entity\Message;
use Core\MessageBundle\Business\MessageBusiness;
use Core\MessageBundle\Entity\MessageUserSent;
use Core\UserBundle\Entity\Users;

class MessageBusinessTest extends \abstraction\test\AbstractTest
{
    /**
     * @var MessageBusiness $business
     */
    private $business;

    /**
     * @var Message $entity
     */
    private $entity;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        $this->initTest();

        $this->entity = new Message();
        $this->business = new MessageBusiness($this->_container);

        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->downTest();

        parent::tearDown();
    }

    /**
     * Testa o save de Message
     */
    public function testShouldSaveEntityMessage ()
    {
        $modelMock = $this->getMock('\Core\MessageBundle\Model\MessageModel', array('save'));
        $modelMock->expects($this->once())
            ->method('save')
            ->with($this->equalTo($this->entity));

        $this->business->setModel($modelMock);

        $this->entity->setDsMessage('Message');
        $this->entity->setDsSubject('Subject');
        $this->entity->setUser(new \Core\UserBundle\Entity\Users());
        $this->business->save($this->entity);

        $this->assertInstanceOf(get_class($this->entity), $this->entity);
    }

    public function testShouldDuplicateEntityMessage ()
    {

    }

    /**
     * setar usuario
     */
    private function _setUser(){
        $userSent = new \Core\MessageBundle\Entity\MessageUserSent();
        $userBusiness = new \Core\UserBundle\Business\UserBusiness();
        $userBusiness->setContainer($this->_container);
        $userSent->setUser($userBusiness->findOne());
        $this->entity->getMessageUserSents()->add($userSent);
    }

    /**
     * testa o validate subject
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateSaveSubject ()
    {
        $this->entity->setDsMessage('mensagem teste');

        $this->_setUser();
        $this->business->_validateSave($this->entity);
    }

    /**
     * testa o validate mensagem
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateSaveMessage ()
    {
        $this->entity->setDsSubject('assunto teste');

        $this->_setUser();

        $this->business->_validateSave($this->entity);
    }

    /**
     * testa o validate user
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateSaveUser ()
    {
        $this->entity->setDsSubject('assunto teste');
        $this->entity->setDsMessage('mensagem teste');

        $this->business->_validateSave($this->entity);
    }

    /**
     * Método que testa o retorno da mensagem
     */
    public function testGetInboxMessage(){
        $arrayModel = array(array('co_message' => '1', 'ds_subject' => 'subject1','user' => 'user1'),
            array('co_message' => '2', 'ds_subject' => 'subject2','user' => 'user2'),
            array('co_message' => '3', 'ds_subject' => 'subject3','user' => 'user3'));
        $modelMock = $this->getMock('Core\MessageBundle\Model\MessageModel',
                                    array('getInboxMessage'));

        $modelMock->expects($this->once())
            ->method('getInboxMessage')
            ->with($this->isInstanceOf(new \Core\UserBundle\Entity\Users()))
            ->will($this->returnValue($arrayModel));

        $this->business->setModel($modelMock);

        $arrayExpects = array(array('co_message' => '1', 'ds_subject' => 'subject1','user' => 'user1'),
            array('co_message' => '2', 'ds_subject' => 'subject2','user' => 'user2'),
            array('co_message' => '3', 'ds_subject' => 'subject3','user' => 'user3'));

        $this->assertEquals($arrayExpects, $this->business->getInboxMessage());
    }

    /**
     * Metodo que testa a remoção da mensagem
     */
    public function testShouldRemoveMessage() {
        $message = $this->business->findOne();

        $this->business->removeMessage($message);

        $this->assertEquals($message->getFlActive(), false);

    }

    /**
     * Método que testa o retorno da mensagem
     */
    public function testGetShowMessage(){

        $mockBusiness = $this->getMock('\Core\MessageBundle\Business\MessageBusiness',
                                       array('callService','find'));

        $mockAbstractBusiness = $this->getMock('abstraction\business\AbstractBusiness', array('findBy'));

        $entityMessageUser = new MessageUserSent();
        $entityMessageUser->setUser(new Users());
        $mockAbstractBusiness->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array( $entityMessageUser)));

        $entity = new Message();
        $entity->setUser(new \Core\UserBundle\Entity\Users());
        $mockBusiness->expects($this->once())
            ->method('find')
            ->will($this->returnValue($entity));

        $mockBusiness->expects($this->once())
            ->method('callService')
            ->will($this->returnValue($mockAbstractBusiness));

        $this->assertTrue(is_array($mockBusiness->getMessage(new Message())));
    }

    /**
     * Método que testa o retorno da mensagem
     */
    public function testGetAnswersMessage(){

        $mockBusiness = $this->getMock('\Core\MessageBundle\Business\MessageBusiness',
                                       array('callService','findBy'));

        $mockAbstractBusiness = $this->getMock('abstraction\business\AbstractBusiness', array('findBy'));

        $entity = new Message();
        $entity->setUser(new \Core\UserBundle\Entity\Users());
        $mockBusiness->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($entity)));

        $entityMessageUser = new MessageUserSent();
        $entityMessageUser->setUser(new Users());
        $mockAbstractBusiness->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array( $entityMessageUser)));

        $mockBusiness->expects($this->once())
            ->method('callService')
            ->will($this->returnValue($mockAbstractBusiness));

        $this->assertTrue(is_array($mockBusiness->getAnswersMessage(new Message())));
    }
}

?>