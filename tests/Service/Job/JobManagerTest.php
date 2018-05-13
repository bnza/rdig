<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 09/05/18
 * Time: 19.47
 */

namespace App\Tests\Service\Job;

use App\Tests\Traits\RealDatabaseWorkflowTrait;
use App\Entity\Job\Job as JobEntity;
use App\Event\Job\JobEventDispatcher;
use App\Service\Job\AbstractDbJob;
use App\Service\Job\JobManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class A extends AbstractDbJob
{
    public static function getName(): string
    {
        return 'test.name';
    }

    public function run(): void
    {
        // TODO: Implement run() method.
    }
}
class JobManagerTest extends KernelTestCase
{
    use RealDatabaseWorkflowTrait;

    public function setUp()
    {
        $this->_setUp('jobs');
    }

    public function testCreateJob()
    {
        $manager = new JobManager($this->em, new JobEventDispatcher());
        $hash = $manager->createJob(A::class);
        $jobEntity = $this->em->getRepository(JobEntity::class)->findByHash($hash);
        $this->assertEquals(A::class, $jobEntity->getClass());
        $this->assertEquals(A::getName(), $jobEntity->getName());
    }

}