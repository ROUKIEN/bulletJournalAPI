<?php

namespace Rukien\BulletJournalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testTaskList()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/tasks');
    $tasks = json_decode($client->getResponse()->getContent(), true);
    $this->assertEquals(count($tasks), 4);
  }
}
