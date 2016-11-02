<?php

namespace Rukien\BulletJournalBundle\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Rukien\BulletJournalBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $user1 = new User([]);
    $user1->setUsername('Bill Murray');
    $user1->setEmail('bill.murray@foobar.com');
    $user1->setType(1);

    $user2 = new User([]);
    $user2->setUsername('Syd Barrett');
    $user2->setEmail('sbarrett@foobar.com');
    $user2->setType(2);

    $user3 = new User([]);
    $user3->setUsername('Ada Lovelace');
    $user3->setEmail('alovelace@foobar.com');
    $user3->setType(1);

    $manager->persist($user1);
    $manager->persist($user2);
    $manager->persist($user3);

    $manager->flush();

    $this->addReference('murray-user', $user1);
    $this->addReference('barrett-user', $user2);
    $this->addReference('lovelace-user', $user3);
  }

  public function getOrder()
  {

  }
}
