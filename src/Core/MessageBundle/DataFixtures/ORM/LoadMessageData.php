<?php
/**
 * Created by IntelliJ IDEA.
 * User: paulo.mendonca
 * Date: 27/08/12
 * Time: 13:28
 * To change this template use File | Settings | File Templates.
 */
namespace Core\MessageBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Core\MessageBundle\Entity\Message;

class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Main method for fixtures insertion
     *
     * @param ObjectManager $manager
     */
    public function load (ObjectManager $manager)
    {
        $entity = new Message();

        $entity->setDsMessage('No no no no no ');
        $entity->setDsSubject('Assunto de teste');
        $entity->setDtCreate(new \DateTime('now'));
        $entity->setFlActive(TRUE);
        $entity->setUser($manager->merge($this->getReference('user-simple')));

        $manager->persist($entity);

        $manager->flush();

        $this->addReference('message', $entity);
    }

    /**
     * Get the order of this execution
     *
     * @return int
     */
    public function getOrder ()
    {
        return 1000;
    }
}
