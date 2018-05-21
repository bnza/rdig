<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BucketRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"campaign", "num"})
 * })
 * @UniqueEntity(
 *      fields={"campaign", "num"},
 *      errorPath="num",
 *      message="Duplicate bucket number [{{ value }}] for this campaign"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Bucket implements SiteRelateEntityInterface
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
     * @Assert\Choice(choices={"O", "P", "S"}, message="Choose a valid type.")
     * @ORM\Column(
     *      type="string",
     *      length=1,
     *      nullable=false,
     *      options={
     *     "fixed" = true
     *     })
     */
    private $type;

    /**
     * @var Campaign
     * Many Buckets have One Campaign.
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="buckets")
     * @ORM\JoinColumn(name="campaign", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $campaign;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d+\w?/")
     * @ORM\Column(type="string", length=5, nullable=false)
     */
    private $num;

    /**
     * @var Context
     * Many Buckets have One Context.
     * @ORM\ManyToOne(targetEntity="Context", inversedBy="buckets")
     * @ORM\JoinColumn(name="context", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $context;

    /**
     * One Bucket has Many Findings.
     * @ORM\OneToMany(targetEntity="Pottery", mappedBy="bucket")
     */
    private $potteries;

    /**
     * One Bucket has Many Findings.
     * @ORM\OneToMany(targetEntity="Object", mappedBy="bucket")
     */
    private $objects;

    /**
     * One Bucket has Many Findings.
     * @ORM\OneToMany(targetEntity="Sample", mappedBy="bucket")
     */
    private $samples;


    public function __construct() {
        $this->potteries = new ArrayCollection();
        $this->objects = new ArrayCollection();
        $this->samples = new ArrayCollection();
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
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return Campaign
     */
    public function getCampaign(): Campaign
    {
        return $this->campaign;
    }

    /**
     * @param Campaign $campaign
     */
    public function setCampaign(Campaign $campaign): void
    {
        $this->campaign = $campaign;
    }

    /**
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param string $num
     */
    public function setNum($num): void
    {
        $this->num = $num;
    }

    /**
     * @return Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    /**
     * @param Pottery $pottery
     */
    public function addPottery(Pottery $pottery)
    {
        $this->potteries[] = $pottery;
        $pottery->setBucket($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getPotteries()
    {
        return $this->potteries;
    }

    /**
     * @param Object $object
     */
    public function addObject(Object $object)
    {
        $this->objects[] = $object;
        $object->setBucket($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getObjects()
    {
        return $this->objects;
    }

    public function getSiteId(): int
    {
        return $this->campaign->getSiteId();
    }

    public function toArray(bool $ancestors = true, bool $descendants = false)
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'num' => $this->num
        ];

        if ($ancestors) {
            $data['campaign'] =  $this->campaign->toArray();
            $data['context'] =  $this->context->toArray();
        }

        return $data;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateBucketNum(LifecycleEventArgs $event)
    {
        $context = $event->getEntity();
        if (!$context->getNum()) {
            $repo = $event->getEntityManager()->getRepository(self::class);
            $num = $repo->getMaxCampaignBucketNum($context->getCampaign()->getId()) + 1;
            $context->setNum($num);
        }

    }

    /**
     * @ORM\PrePersist
     * @param LifecycleEventArgs $event
     */
    public function formatNum(LifecycleEventArgs $event)
    {
        $bucket = $event->getEntity();
        $num = $bucket->getNum();
        $num = sprintf("%'.05s", $num);
        $bucket->setNum($num);
    }

    public function __toString()
    {
        $campaign = $this->getCampaign() ? (string) $this->getCampaign() : 'XX.0000';
        if (in_array(substr($campaign, 0, 2), ['TH', 'TG']))
        {
            $area = $this->getContext() ? $this->getContext()->getArea() : null;
            $bucketCode = $area ? $area->getCode() : 'XX';
        } else
        {
            $bucketCode = $this->getType() ? $this->getType() : 'X';
        }
        $bucketNum = $this->getNum() ? $this->getNum() : '0';
        return "$campaign.$bucketCode.$bucketNum";

    }
}
