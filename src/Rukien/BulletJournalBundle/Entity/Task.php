<?php
namespace Rukien\BulletJournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \JsonSerializable;

/**
 * @ORM\Entity
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
   * @ORM\ManyToMany(targetEntity="User", inversedBy="tasks")
   * @ORM\JoinTable(name="tasks_has_assignees",
   *    joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="task_id")},
   *    inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")}
   * )
   */
  protected $assignees;

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
    if(isset($values['title']) )
      $this->setTitle( $values['title'] );

    $this->setDone( isset($values['done']) ? $values['done'] : false );
    $this->setPriority( isset($values['priority']) ? $values['priority'] : self::PRIORITY_MED );
    if(isset($values['due_date']) )
      $this->setDueDate( new \DateTime($values['due_date']) );
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
        $this->due_date = $dueDate;

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
        $this->created_at = $createdAt;

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
        $this->updated_at = $updatedAt;

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
      return [
        'task_id' => $this->getTaskId(),
        'title' => $this->getTitle(),
        'priority' => $this->getPriority(),
        'done' => $this->getDone(),
        'created_at' => $this->getCreatedAt(),
        'updated_at' => $this->getUpdatedAt(),
        'due_date' => $this->getDueDate(),
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
     * Add assignees
     *
     * @param \Rukien\BulletJournalBundle\Entity\User $assignees
     * @return Task
     */
    public function addAssignee(\Rukien\BulletJournalBundle\Entity\User $assignees)
    {
        $this->assignees[] = $assignees;

        return $this;
    }

    /**
     * Remove assignees
     *
     * @param \Rukien\BulletJournalBundle\Entity\User $assignees
     */
    public function removeAssignee(\Rukien\BulletJournalBundle\Entity\User $assignees)
    {
        $this->assignees->removeElement($assignees);
    }

    /**
     * Get assignees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignees()
    {
        return $this->assignees;
    }
}
