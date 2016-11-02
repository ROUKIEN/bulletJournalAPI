<?php

namespace Rukien\BulletJournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Rukien\BullerJournalBundle\Entity\UserRepository;

class UserController extends Controller
{
    /**
     * @Route("/users/{user_id}", name="user_summary_task", requirements={"user_id": "\d+"})
     * @Method({"GET"})
     */
    public function indexAction($user_id = 0)
    {
      $repo = $this->getDoctrine()->getRepository('RukienBulletJournalBundle:User');
      $users = $repo->getUsersSummary($user_id);
      if(count($users) == 1 && $user_id > 0)
        $users = $users[0];
      return new JsonResponse($users);
    }
}
