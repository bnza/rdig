<?php

namespace App\Controller;

use App\Service\SiteFilter;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home"))
     */
    public function index(SiteFilter $siteFilter)
    {
        $site = $siteFilter->getSite();

        $filteredSite = [];
        if ($site) {
            $filteredSite = [
                'code' => $site->getCode(),
                'name' => $site->getName(),
            ];
        }

        return $this->render(
            'home/app.html.twig',
            [
                'filteredSite' => $filteredSite,
            ]
        );
    }

    /**
     * @Route("/fsc/sites")
     *
     * @param SiteRepository $repo
     *
     * @return JsonResponse
     */
    public function getSites(SiteRepository $repo)
    {
        $sites = $repo->findAllAsArray();

        return new JsonResponse($sites);
    }

    /**
     * @Route("/fsc/reset/{redirect}", requirements={"redirect"="[0|1]"})
     *
     * @param SiteFilter $siteFilter
     * @param int        $redirect
     *
     * @return RedirectResponse|Response
     */
    public function resetSiteFilter(SiteFilter $siteFilter, $redirect = 1)
    {
        $success = $siteFilter->setSiteCode('');
        if ($redirect) {
            return $this->redirectToRoute('home');
        } else {
            $status = $success ? 200 : 400;
            $content = $success
                ? 'Site filter resetted'
                : 'Cannot reset site';

            return new Response($content, $status, ['Content-Type: text/plain; charset=utf-8']);
        }
    }

    /**
     * @Route("/fsc/{code}/{redirect}", requirements={"code" = "\w{2}", "redirect"="[0|1]"})
     *
     * @param SiteFilter $siteFilter
     * @param $code
     * @param int $redirect
     *
     * @return RedirectResponse|Response
     */
    public function setSiteFilter(SiteFilter $siteFilter, $code, $redirect = 1)
    {
        $site = $siteFilter->setSiteCode($code);
        if ($redirect) {
            return $this->redirectToRoute('home');
        } else {
            $status = $site ? 200 : 400;
            $content = $site
                    ? [
                        'code' => $site->getCode(),
                        'name' => $site->getName(),
                      ]
                    : "Cannot set site filter to $code";

            return new JsonResponse($content, $status);
        }
    }
}
