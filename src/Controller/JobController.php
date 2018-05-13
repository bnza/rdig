<?php

namespace App\Controller;

use App\Service\Job\JobManager;
use App\Service\Job\Csv\CsvImportPotteryFromFileJob;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/jobs")
 */
class JobController extends Controller
{
    /**
     * @Route("/csv/import/create")
     */
    public function createJob(JobManager $manager)
    {
        $hash = $manager->createJob(CsvImportPotteryFromFileJob::class);
        return new JsonResponse(['hash' => $hash]);
    }

    /**
     * @Route("/csv/import/run/{hash}", requirements={"hash" = "\w+"})
     */
    public function runJob(JobManager $manager, string $hash)
    {
        $em = $this->get('doctrine.orm.jobs_entity_manager');
        $dataEm = $this->get('doctrine.orm.default_entity_manager');

        $job = $manager->runJob($hash, [$em, $dataEm]);
        return new JsonResponse(['hash' => $hash, 'done' => true, 'steps' => count($job->getTaskList())]);
    }

}
