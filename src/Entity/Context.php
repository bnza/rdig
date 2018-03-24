<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContextRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"num", "site"})
 * })
 * @UniqueEntity(
 *      fields={"num", "site"},
 *      message="Duplicate context number for this area"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Context implements SiteRelateEntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *  @Assert\Length(
     *     min = 1,
     *     max = 1
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=1, nullable=false, options={"fixed" = true})
     */
    private $type = "F";

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", nullable=false, options={"unsigned" = true})
     */
    private $num = 0;

    /**
     * @var Site
     * Many Context have One Site.
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="contexts")
     * @ORM\JoinColumn(name="site", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $site;

    /**
     * @var Area
     * Many Context have One Site.
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="contexts")
     * @ORM\JoinColumn(name="area", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $area;

    /**
     * One Site has Many Areas.
     * @ORM\OneToMany(targetEntity="Bucket", mappedBy="context")
     */
    private $buckets;

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
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param mixed $num
     */
    public function setNum($num): void
    {
        $this->num = $num;
    }

    /**
     * @return Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @return ArrayCollection
     */
    public function getBuckets()
    {
        return $this->buckets;
    }

    /**
     * @param Bucket $bucket
     */
    public function addBuckets(Bucket $bucket)
    {
        $this->buckets[] = $bucket;
        $bucket->setContext($this);
    }

    /**
     * @param Area $area
     * @throws \Exception
     */
    public function setArea(Area $area): void
    {
        if (is_null($this->site)) {
            $this->site = $area->getSite();
        } else {
            if ($area->getSite()->getId() !== $this->site->getId()) {
                $areaName = $area->getName();
                $siteName = $this->site->getName();
                // TODO find right exception
                throw new \Exception("Area \"$areaName\" does not belong to site \"$siteName\"");
            }
        }
        $this->area = $area;
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
    public function setSite(Site $site): void
    {
        $this->site = $site;
    }

    public function getSiteId(): int
    {
        return $this->site->getId();
    }

    /**
     * @ORM\PrePersist
     */
    public function generateContextNum(LifecycleEventArgs $event)
    {
        $context = $event->getEntity();
        if (!$context->getNum()) {
           $repo = $event->getEntityManager()->getRepository(self::class);
           $num = $repo->getMaxSiteContextNum($context->getSite()->getId()) + 1;
           $context->setNum($num);
        }

    }

    public function toArray(bool $ancestors = true, bool $descendants = false)
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'num' => $this->num
        ];

        if ($ancestors) {
            $data['area'] =  $this->area->toArray(true);
        }

        return $data;
    }
}