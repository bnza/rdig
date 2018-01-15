<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 15/01/18
 * Time: 17.36.
 */

namespace App\Tests\Traits;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

trait RealDatabaseWorkflowTrait
{
    protected $application;
    /**
     * @var
     */
    protected $output;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected function dropSchema()
    {
        try {
            $input = new ArrayInput(array(
                'command' => 'doctrine:schema:drop',
                '--force' => true,
            ));

            $this->application->run($input, $this->output);
        } catch (\Exception $e) {
        }
    }

    protected function createSchema()
    {
        $input = new ArrayInput(array(
            'command' => 'doctrine:database:create',
        ));

        $this->application->run($input, $this->output);
    }

    protected function updateSchema()
    {
        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:update',
            // (optional) pass options to the command
            '--force' => true,
        ));

        $this->application->run($input, $this->output);
    }

    protected function _setUp()
    {
        self::bootKernel();
        $this->output = new NullOutput();
        $this->application = new Application(self::$kernel);
        $this->application->setAutoExit(false);
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->dropSchema();
        $this->createSchema();
        $this->updateSchema();
    }

    protected function _tearDown()
    {
        $this->dropSchema();
    }
}
