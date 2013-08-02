<?php
namespace Core\MessageBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppKernel;
use appTestDebugProjectContainer;
use Core\MessageBundle\Entity\Message;
use Core\MessageBundle\Business\MessageBusiness;

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
    public function testSave ()
    {
        $user = new \Core\UserBundle\Business\UserBusiness($this->_container);

        $this->entity->setDsMessage('Message');
        $this->entity->setDsSubject('Subject');
        $this->entity->setUser($user->findOne());
        $this->business->save($this->entity);

        $this->assertInstanceOf(get_class($this->entity), $this->entity);
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
     * testa a remoção da mensagem
     */
    public function testShouldValidateRemoveMessage ()
    {
        $message = $this->business->findOne();

        $this->business->removeMessage($message);

        $this->assertEquals($message->getFlActive(), false);
    }
}
