<?php
namespace Core\MessageBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppKernel;
use appTestDebugProjectContainer;
use Core\UserBundle\Entity\Users;
use Core\MessageBundle\Entity\MessageUserSent;
use Core\MessageBundle\Business\MessageUserSentBusiness;

class MessageUserSentBusinessTest extends \abstraction\test\AbstractTest
{
    /**
     * @var MessageUserSentBusiness $business
     */
    private $business;

    /**
     * @var MessageUserSent $entity
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
    public function testSave ()
    {
        $user = new \Core\UserBundle\Business\UserBusiness($this->_container);
        $message = new \Core\MessageBundle\Business\MessageBusiness($this->_container);

        $this->entity->setUser($user->findOne());
        $this->entity->setMessage($message->findOne());
        $this->entity->setFlRead(false);
        $this->business->save($this->entity);

        $this->assertInstanceOf(get_class($this->entity), $this->entity);
    }

    /**
     * testa o validate User
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateUser ()
    {
        $message = new \Core\MessageBundle\Business\MessageBusiness($this->_container);

        $this->entity->setMessage($message->findOne());
        $this->entity->setFlRead(false);

        $this->business->_validateSave($this->entity);
    }

    /**
     * testa o validate Message
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateMessage ()
    {
        $user = new \Core\UserBundle\Business\UserBusiness($this->_container);

        $this->entity->setUser($user->findOne());
        $this->entity->setFlRead(false);

        $this->business->_validateSave($this->entity);
    }

    /**
     * testa a remoção do messageUserSent
     * @expectedException abstraction\business\exception\ExceptionBusiness
     */
    public function testShouldValidateRemoveMessageUserSent ()
    {
        $message = $this->business->findOne();

        $this->business->removeMessage($message);

        $this->assertEquals($message->getFlActive(), false);
    }

}