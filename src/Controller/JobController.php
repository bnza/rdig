<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Service\Job\JobManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/job")
 */
class JobController extends Controller
{
    /**
     * @Route("/csv/export/{entityName}/create", name="app_job_create_csv_export", requirements={"entityName" = "object|pottery|sample"})
     * @param JobManager $manager
     * @param AuthorizationCheckerInterface $authChecker
     * @param string entityName
     * @return JsonResponse
     */
    public function createCsvExportFindingToFileJob(JobManager $manager, AuthorizationCheckerInterface $authChecker, string $entityName)
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return new JsonResponse('Access Denied.', '403');
        }
        $class = "App\\Service\\Job\\Csv\\CsvExport".ucfirst($entityName)."ToFileJob";
        $hash = $manager->createJob($class);
        return new JsonResponse(['hash' => $hash]);
    }

    /**
     * @Route("/csv/export/{entityName}/run/{hash}", name="app_job_run_csv_export", requirements={"entityName" = "object|pottery|sample", "hash" = "\w+"})
     * @param Request $request
     * @param JobManager $manager
     * @param AuthorizationCheckerInterface $authChecker
     * @param string $entityName
     * @param string $hash
     * @return BinaryFileResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function runJob(Request $request, JobManager $manager,  AuthorizationCheckerInterface $authChecker, string $entityName, string $hash)
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return new JsonResponse('Access Denied.', '403');
        }
        $em = $this->get('doctrine.orm.jobs_entity_manager');
        $dataEm = $this->get('doctrine.orm.default_entity_manager');
        $sort = $request->get('sort') ?: [];
        $filter = $request->get('filter') ?: [];
        /**
         * @var \App\Service\Job\Csv\AbstractCsvExportFindingToFileJob
         */
        $job = $manager->runJob($hash, [$em, $dataEm, $entityName, $filter, $sort]);
        $filename = $job->getCsvOutputPath();
        $response = new BinaryFileResponse($filename);
        $response->headers->set('Content-Type', 'text/csv');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($filename)
        )->deleteFileAfterSend(true);
        return $response;
    }

}
