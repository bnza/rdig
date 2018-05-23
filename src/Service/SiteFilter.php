<?php

namespace App\Service;

use App\Entity\Main\Site;
use App\Repository\SiteRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SiteFilter
{
    const SESSION_KEY = 'rdig.filter_site_code';
    /**
     * @var Session
     */
    private $session;

    /**
     * @var SiteRepository
     */
    private $repo;

    /**
     * SiteFilter constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param SiteRepository $repo
     */
    public function setRepository(SiteRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Set the site code used by general all AbstractDataRepository for filtering.
     * If site code does not exist fails silently.
     *
     * @param string $code
     *
     * @return Site|bool
     */
    public function setSiteCode(string $code = '')
    {
        if (!$code) {
            $this->session->remove(self::SESSION_KEY);

            return true;
        } elseif ($site = $this->repo->findByCode($code)) {
            $this->session->set(self::SESSION_KEY, $code);

            return $site;
        }

        return false;
    }

    public function getSiteCode()
    {
        if ($this->session->has(self::SESSION_KEY)) {
            return $this->session->get(self::SESSION_KEY);
        }
    }

    public function getSite()
    {
        if ($this->session->has(self::SESSION_KEY)) {
            return $this->repo->findByCode($this->session->get(self::SESSION_KEY));
        }
    }
}
