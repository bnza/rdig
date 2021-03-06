<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhaseRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"site", "name"})
 * })
 * @UniqueEntity(
 *      fields={"site", "name"},
 *      errorPath="name",
 *      message="Duplicate phase name [{{ value }}] for this site"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Phase implements SiteRelateEntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Site
     * Many Areas have One Site.
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="phases")
     * @ORM\JoinColumn(name="site", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $site;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * One Site has Many Areas.
     * @ORM\OneToMany(targetEntity="Context", mappedBy="phase")
     */
    private $contexts;

    public function __construct() {
        $this->buckets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param Site $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * @throws \Exception
     */
    public function addContext(Context $context)
    {
        $this->contexts[] = $context;
        $context->setPhase($this);
    }

    public function getSiteId(): int
    {
        return $this->site->getId();
    }

    public function toArray(bool $ancestors = true, bool $descendants = false)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if ($ancestors) {
            $data['site'] =  $this->site->toArray();
        }

        return $data;
    }

    public function __toString()
    {
        $siteCode = 'XX';
        if ($this->getSite()) {
            $siteCode = $this->getSite()->getCode() ? $this->getSite()->getCode() : $siteCode;
        }
        return "$siteCode.{$this->getName()}";
    }

}
