<?php
namespace Rukien\BulletJournalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @class DefaultControllerTest
 */
class DefaultControllerTest extends WebTestCase
{
  /**
   * Verifies the API is up and running
   */
  public function testIndex()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  /**
   * Verifies the number of loaded tasks is correct
   */
  public function testTaskList()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/tasks');
    $tasks = json_decode($client->getResponse()->getContent(), true);
    $this->assertEquals(count($tasks), 5);
  }
}

