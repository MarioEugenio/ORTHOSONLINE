<?php

namespace Core\MessageBundle\Tests\Unity\Business;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppKernel;
use appTestDebugProjectContainer;
use Core\MessageBundle\Entity\MessageUserSent;
use Core\MessageBundle\Business\MessageUserSentBusiness;
use Core\UserBundle\Entity\Users;
use Core\MessageBundle\Entity\Message;

class MessageUserSentBusinessTest extends \abstraction\test\AbstractTest
{
    /**
     * @var MessageUserSentBusiness $business
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

        $this->entity = new MessageUserSent();
        $this->business = new MessageUserSentBusiness($this->_container);

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
    public function testShouldSaveEntityMessageUserSent ()
    {
        $modelMock = $this->getMock('\Core\MessageBundle\Model\MessageUserSentModel', array('save'));
        $modelMock->expects($this->once())
            ->method('save')
            ->with($this->equalTo($this->entity));

        $this->business->setModel($modelMock);

        $this->entity->setUser(new Users());
        $this->entity->setMessage(new Message());
        $this->business->save($this->entity);

        $this->assertInstanceOf(get_class($this->entity),$this->entity);
    }

    /**
     * testa o validate user
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateUser ()
    {
        $this->entity->setDtCreate(new \DateTime('now'));
        $this->entity->setMessage(new Message());

        $this->business->_validateSave($this->entity);
    }

    /**
     * testa o validate Data de Criação
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateDtCreate ()
    {
        $this->entity->setDtCreate(null);
        $this->entity->setMessage(new Message());
        $this->entity->setUser(new Users());

        $this->business->_validateSave($this->entity);
    }

    /**
     * testa o validate Message
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateMessage ()
    {
        $this->entity->setDtCreate(new \DateTime('now'));
        $this->entity->setUser(new Users());

        $this->business->_validateSave($this->entity);
    }

    /**
     * O teste deve validar a remoção do messageUserSent
     */
    public function testShouldValidateRemoveMessageUserSent ()
    {
        $messageUserSent = $this->business->findOne();
        $this->business->removeMessageUserSent($messageUserSent);
        $this->assertEquals($messageUserSent->getFlActive(), false);
    }

}

?>