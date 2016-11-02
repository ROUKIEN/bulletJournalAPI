<?php

namespace Rukien\BulletJournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Rukien\BulletJournalBundle\Entity\Task;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return new JsonResponse([]);
    }

    /**
     * Get one or all the existing tasks. If no task id was specified,
     * the action returns every Task entities.
     *
     * @Route("/tasks/{task_id}", name="show_task", requirements={"task_id": "\d+"})
     * @Method({"GET"})
     */
    public function showTaskAction($task_id = 0)
    {
      $repo = $this->getDoctrine()->getRepository('RukienBulletJournalBundle:Task');
      if($task_id > 0) {
        $task = $repo->findOneBy(['task_id' => $task_id]);
        if($task) {
          return new JsonResponse($task);
        }
        else return new Response('This task does not exists', Response::HTTP_NOT_FOUND);
      }
      else {
        $tasks = $repo->findAll();

        if(!empty($tasks)) {
          return new JsonResponse($tasks);
        }
        else return new Response('No Tasks found', Response::HTTP_BAD_REQUEST);
      }
    }

    /**
     * Create a new Task, filling the missing params with default values.
     * Task values must be send as a JSON object.
     *
     * The action returns the created entity as a json object.
     *
     * @Route("/tasks", name="create_task")
     * @Method({"POST"})
     */
    public function createTaskAction()
    {
      $data = $this->get("request")->getContent();
      if(!empty($data)) 
      {
        $data = json_decode($data, true);
        $task = new Task($data);

        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return new JsonResponse($task);
      }
      else return new Response('Task could not be saved : missing fields', Response::HTTP_BAD_REQUEST);
    }
    
    /**
     * Updates the values of a given task. 
     * It only update entity attributes that were present in the query.
     * This action also returns the updated entity as a JSON object if needed by the frontend.
     *
     * @Route("/tasks/{task_id}", name="update_task", requirements={"task_id": "\d+"})
     * @Method({"PUT", "PATCH"})
     */
    public function updateTaskAction($task_id = 0)
    {
      $data = $this->get('request')->getContent();
      if(!empty($data))
      {
        $data = json_decode($data, true);
        $repo = $this->getDoctrine()->getRepository('RukienBulletJournalBundle:Task');
        $task = $repo->findOneBy(['task_id' => $task_id]);
        if($task)
        {
          /*
            @TODO find a way to improve this part. It is quite cumbersome right now :
            When an attribute is found as a key of the following array, it calls the
            corresponding setter on the entity.
           */
          $fields = [
            'title' => 'setTitle',
            'due_date' => 'setDueDate',
            'done' => 'setDone',
            'priority' => 'setPriority',
            'summary' => 'setSummary',
          ];
          foreach($data as $key => $value)
          {
            if(array_key_exists($key, $fields)) {
              $action = $fields[$key];
              $task->$action($value);
            }
          }
          // Manage the assignee if it has been set
          if($data['assignee'] != null)
          {
            $assignee = $this->getDoctrine()->getManager()->getReference('RukienBulletJournalBundle:User', $data['assignee']['user_id']);
            $task->setAssignee($assignee);
          }

          $this->getDoctrine()->getManager()->flush();
          return new JsonResponse($task);
        } else return new Response('No task found', Response::HTTP_BAD_REQUEST);
      } else return new Response('Nothing to update !', Response::HTTP_BAD_REQUEST);

    }
    
    /**
     * Simply delete a task by its unique identifier
     *
     * @Route("/tasks/{task_id}", name="delete_task", requirements={"task_id":"\d+"})
     * @Method({"DELETE"})
     */
    public function deleteTaskAction($task_id) 
    {
      // It could be more efficient by using a custom entity repository and
      // create a custom query deleting by ID. To improve later.
      $repo = $this->getDoctrine()->getRepository('RukienBulletJournalBundle:Task');
      $task = $repo->findOneBy(['task_id' => $task_id]);
      if($task)
      {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        return new Response('Task deleted', Response::HTTP_OK);
      }
      else return new Response('Task does not exists', Response::HTTP_NOT_FOUND);
    }
    
    /**
     * @Route("/tasks/not-assigned")
     */
    public function tasksNotAssignedAction() 
    {
      $repo = $this->getDoctrine()->getRepository('RukienBulletJournalBundle:Task');
      return new JsonResponse($repo->getNotAssignedTasks());
    }
}
