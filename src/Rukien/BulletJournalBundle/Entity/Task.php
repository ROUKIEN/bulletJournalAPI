<?php
namespace Rukien\BulletJournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rukien\BulletJournalBundle\Entity\TaskRepository")
 * @ORM\Table(name="task")
 * @ORM\HasLifecycleCallbacks
 */
class Task implements JsonSerializable
{

  const PRIORITY_MIN = 3;
  const PRIORITY_MED = 2;
  const PRIORITY_MAX = 1;

  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $task_id;

  /**
   * @ORM\Column(type="string", length=45)
   * @var task title, 45 chars long
   */
  protected $title;

  /**
   * @ORM\Column(type="boolean")
   * @var task done/not done
   */
  protected $done;

  /**
   * @ORM\Column(type="smallint")
   * @var task priority : can be from PRIORITY_LOW to PRIORITY_MAX
   */
  protected $priority;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $due_date;

  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
   */
  protected $assignee;

  /**
   * @ORM\Column(type="text")
   */
  protected $summary;

  /**
   * @ORM\Column(type="datetime")
   */
  protected $created_at;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $updated_at;

  public function __construct(array $values) 
  {
    if( isset($values['title']) )
      $this->setTitle( $values['title'] );
    if( isset($values['summary']) )
      $this->setSummary( $values['summary'] );
    $this->setDone( isset($values['done']) ? $values['done'] : false );
    $this->setPriority( isset($values['priority']) ? $values['priority'] : self::PRIORITY_MED );
    if(isset($values['due_date']) && $values['due_date'] != '' )
      $this->setDueDate( $values['due_date'] );
  }

  /**
   * @ORM\PrePersist
   */
  public function onPrePersist()
  {
    $this->created_at = new \DateTime();
  }

    /**
     * Get task_id
     *
     * @return integer 
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set done
     *
     * @param boolean $done
     * @return Task
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean 
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set due_date
     *
     * @param \DateTime $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = new \DateTime($dueDate);

        return $this;
    }

    /**
     * Get due_date
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Task
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = new \DateTime($createdAt);

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Task
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = new \DateTime($updatedAt);

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    /**
     * jsonSerialize implementation for Task Entity
     * @return array
     */
    public function jsonSerialize() {

      // This would be a workaround for the warning in the User Entity (@See User:jsonSerialize())
      $assignee = $this->getAssignee();
      $assigned_user = null;
      if($assignee) 
      {
        $assigned_user = [
          'username' => $assignee->getUsername(),
          'email' => $assignee->getEmail(),
          'type' => $assignee->getType(),
          'user_id' => $assignee->getUserId(),
        ];
      }
      return [
        'task_id' => $this->getTaskId(),
        'title' => $this->getTitle(),
        'priority' => $this->getPriority(),
        'done' => $this->getDone(),
        'summary' => $this->getSummary(),
        'created_at' => !empty($this->getCreatedAt()) ? $this->getCreatedAt()->format('Y-m-d') : '',
        'updated_at' => !empty($this->getUpdatedAt()) ? $this->getUpdatedAt()->format('Y-m-d') : '',
        'due_date' => !empty($this->getDueDate()) ? $this->getDueDate()->format('Y-m-d') : '',
        'assignee' => $assigned_user
      ];
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Task
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set assignee
     *
     * @param \Rukien\BulletJournalBundle\Entity\User $assignee
     * @return Task
     */
    public function setAssignee(\Rukien\BulletJournalBundle\Entity\User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return \Rukien\BulletJournalBundle\Entity\User 
     */
    public function getAssignee()
    {
        return $this->assignee;
    }
}
