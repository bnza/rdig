<?php

namespace App\Entity;

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
 *      message="Duplicate bucket number for this campaign"
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
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned" = true})
     */
    private $num = 0;

    /**
     * @var Context
     * Many Buckets have One Context.
     * @ORM\ManyToOne(targetEntity="Context", inversedBy="buckets")
     * @ORM\JoinColumn(name="context", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $context;

    /**
     * One Bucket has Many Findings.
     * @ORM\OneToMany(targetEntity="AbstractFinding", mappedBy="bucket")
     */
    private $findings;


    public function __construct() {
        $this->findings = new ArrayCollection();
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
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param int $num
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
}
