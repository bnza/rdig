<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FindingRepository")
 * @ORM\Table(name="finding")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string", length=1)
 * @ORM\DiscriminatorMap({"O" = "Object", "P" = "Pottery", "S" = "Sample"})
 * @UniqueEntity(
 *      fields={"bucket", "num"},
 *      errorPath="num",
 *      message="Duplicate finding number for this bucket"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractFinding implements SiteRelateEntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bucket
     *             Many Buckets have One Campaign
     * @ORM\ManyToOne(targetEntity="Bucket", inversedBy="findings")
     * @ORM\JoinColumn(name="bucket", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $bucket;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=4, nullable=false)
     */
    private $num;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text", length=4, nullable=true)
     */
    private $remarks;

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     */
    public function setRemarks($remarks): void
    {
        $this->remarks = $remarks;
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Bucket
     */
    public function getBucket(): Bucket
    {
        return $this->bucket;
    }

    /**
     * @param Bucket $bucket
     */
    public function setBucket(Bucket $bucket): void
    {
        $this->bucket = $bucket;
    }

    /**
     * @return int
     */
    public function getSiteId(): int
    {
        return $this->bucket->getSiteId();
    }

    public function toArray(bool $ancestors = true, bool $descendants = false)
    {
        return [
          'id' => '@TODO',
        ];
    }

    /**
     * @ORM\PrePersist
     */
    public function formatNum(LifecycleEventArgs $event)
    {
        $finding = $event->getEntity();
        $num = $finding->getNum();
        if (is_numeric($num)) {
            $num = sprintf('%010d', $finding->getNum());
        }
        $finding->setNum($num);
    }
}
