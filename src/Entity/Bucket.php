<?php

namespace App\Entity;

use App\Repository\BucketRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="BucketRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"campaign", "num"})
 * })
 * @UniqueEntity(
 *      fields={"campaign", "num"},
 *      errorPath="num",
 *      message="Duplicate bucket number for this campaign"
 * )
 */
class Bucket implements CrudEntityInterface
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
     *     "fixed" = true,
     *     "check"="CHECK (type IN ('O', 'P', 'S'))"
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

    public function toArray(bool $ancestors = true, bool $descendants = false)
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'num' => $this->num
        ];

        if ($ancestors) {
            $data['campaign'] =  $this->campaign->toArray();
        }

        return $data;
    }

    /**
     * @param LifecycleEventArgs $event
     * @ORM\PrePersist
     */
    public function generateBucketNum(LifecycleEventArgs $event)
    {
        $context = $event->getEntity();
        if (!$context->getNum()) {
            /**
             * @var BucketRepository
             */
            $repo = $event->getEntityManager()->getRepository(self::class);
            $num = $repo->getMaxCampaignBucketNum($context->getSite()->getId()) + 1;
            $context->setNum($num);
        }

    }
}
