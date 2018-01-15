<?php

namespace App\Tests;

use App\Tests\Traits\RealDatabaseWorkflowTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


abstract class RealDatabaseWorkflowWebTestCase extends WebTestCase
{

    use RealDatabaseWorkflowTrait;

    public function setUp()
    {
        $this->_setUp();
    }

    public function tearDown()
    {
        $this->_tearDown();
    }
}
