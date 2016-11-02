<?php
namespace Rukien\BulletJournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rukien\BulletJournalBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements JsonSerializable
{
  const TYPE_REPORTER = 'reporter';
  const TYPE_DEVELOPER = 'developer';
  const TYPE_TESTER = 'tester';
  const TYPE_BOSS = 'boss';

  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $user_id;

  /**
   * @ORM\Column(type="string", length=45)
   * @var username, 45 chars long
   */
  protected $username;

  /**
   * @ORM\Column(type="string", length=100)
   * @var user email
   */
  protected $email;

  /**
   * @ORM\Column(type="string")
   * @var user type : reporter, developer...
   */
  protected $type;
  
  /**
   * @ORM\OneToMany(targetEntity="Task", mappedBy="assignee")
   */
  protected $tasks;

  public function __construct(array $values) 
  {

  }
    
  /**
   * jsonSerialize implementation for Task Entity
   * @return array
   */
  public function jsonSerialize() {
    return [
      'user_id' => $this->getUserId(),
      'username' => $this->getUsername(),
      'email' => $this->getEmail(),
      'type' => $this->getType(),
      // /!\ WARNING : take care of it : if tasks know the associated entity, it could throw an infinite loop
      'tasks' => array_map(function($task){ return $task->jsonSerialize(); }, $this->getTasks()->toArray()),
    ];
  }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add tasks
     *
     * @param \Rukien\BulletJournalBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\Rukien\BulletJournalBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Rukien\BulletJournalBundle\Entity\Task $tasks
     */
    public function removeTask(\Rukien\BulletJournalBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
