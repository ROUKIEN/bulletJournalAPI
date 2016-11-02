<?php

namespace Rukien\BulletJournalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends EntityRepository
{
  public function getNotAssignedTasks()
  {
    $dql = 'SELECT t FROM RukienBulletJournalBundle:Task t LEFT JOIN t.assignees u WHERE u IS NULL';
    return $this->getEntityManager()
      ->createQuery($dql)->getResult();
  }
}
