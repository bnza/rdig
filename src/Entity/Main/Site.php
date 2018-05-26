<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 * @UniqueEntity(
 *      fields={"code"},
 *      message="Duplicate site code"
 * )
 */
class Site implements SiteRelateEntityInterface
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 2
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=2, unique=true, nullable=false)
     */
    private $code;

    /**
     * @Assert\Length(
     *      max = 64
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * Many Sites have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="sites")
     */
    private $users;

    /**
     * One Site has Many Areas.
     * @ORM\OneToMany(targetEntity="Area", mappedBy="site")
     */
    private $areas;

    /**
     * One Site has Many Areas.
     * @ORM\OneToMany(targetEntity="Context", mappedBy="site")
     */
    private $contexts;

    /**
     * One Site has Many Areas.
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="site")
     */
    private $campaigns;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->areas = new ArrayCollection();
        $this->contexts = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * @param Area $area
     */
    public function addArea(Area $area)
    {
        $this->areas[] = $area;
        $area->setSite($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @param Context $context
     */
    public function addContexts(Context $context)
    {
        $this->contexts[] = $context;
        $context->setSite($this);
    }

    /**
     * @return mixed
     */
    public function getCampaigns()
    {
        return $this->campaigns;
    }

    /**
     * @param Campaign $campaign
     */
    public function addCampaign(Campaign $campaign)
    {
        $this->campaigns[] = $campaign;
        $campaign->setSite($this);
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code): void
    {
        $this->code = strtoupper($code);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getSiteId(): int
    {
        return $this->getId();
    }

    public function toArray(bool $ancestors = true, bool $descendants = false)
    {
        $data = [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name
        ];

        return $data;
    }
}
