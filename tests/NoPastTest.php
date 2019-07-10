<?php


namespace App\Tests;


use App\Entity\Visit;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NoPastTest extends WebTestCase
{
    /**
     * @throws \Exception
     */
    public function testNoPast()
    {
        $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

        $visit = new Visit();
        $this->assertGreaterThanOrEqual($visit->getVisitDate()->format('y/m/d H:m:s'),$now->format('y/m/d H:m:s'));

    }



}