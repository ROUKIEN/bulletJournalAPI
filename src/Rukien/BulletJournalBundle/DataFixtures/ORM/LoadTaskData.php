<?php

namespace Rukien\BulletJournalBundle\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Rukien\BulletJournalBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $task1 = new Task([
      'title' => 'Fix some bugs',
      'summary' => 'We need to remove the following bug from our app',
      'due_date' => '2016-12-26',
      'done' => false,
      'priority' => Task::PRIORITY_MAX,
    ]);
    $task1->setAssignee($this->getReference('lovelace-user'));

    $task2 = new Task([
      'title' => 'Finish Megaman 2',
      'summary' => 'We need to remove the following bug from our app',
      'done' => false,
      'priority' => Task::PRIORITY_MIN,
    ]);

    $task3 = new Task([
      'title' => 'Improve task assignation',
      'summary' => 'Manage a drag and drop system from the dashboard screen, where user can drag an unassigned task from the left list to the user list',
      'due_date' => '2016-12-01',
      'done' => false,
      'priority' => Task::PRIORITY_MIN,
    ]);
    $task3->setAssignee($this->getReference('lovelace-user'));

    $task4 = new Task([
      'title' => 'Write fixtures',
      'summary' => 'We need some fixtures.',
      'due_date' => '2016-11-21',
      'done' => true,
      'priority' => Task::PRIORITY_MED,
    ]);
    $task4->setAssignee($this->getReference('barrett-user'));

    $task5 = new Task([
      'title' => 'Better REST management',
      'summary' => 'We use ngResource to manage the communications with the API. See how we can improve routes, and be more specific about the API standards (go for a versionned API, for example : http://<api-server>/api/1.0/tasks)',
      'due_date' => '2016-11-15',
      'done' => false,
      'priority' => Task::PRIORITY_MAX,
    ]);
    $task5->setAssignee($this->getReference('lovelace-user'));

    $manager->persist($task1);
    $manager->persist($task2);
    $manager->persist($task3);
    $manager->persist($task4);
    $manager->persist($task5);
    $manager->flush();
  }

  public function getOrder()
  {
    return 2;
  }
}
