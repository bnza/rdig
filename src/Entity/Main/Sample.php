<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/05/18
 * Time: 9.15
 */

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *
 * @ORM\Table(name="sample", uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"site", "no"})
 * })
 *
 * @UniqueEntity(
 *      fields={"site", "no"},
 *      errorPath="no",
 *      message="Duplicate registration number [{{ value }}] for this site "
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\SampleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Sample extends AbstractFinding
{
    /**
     * @var Site
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumn(name="site", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $site;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $no;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;

    /**
     * @var VocSType
     * @ORM\ManyToOne(targetEntity="VocSType")
     * @ORM\JoinColumn(name="type", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $type;

    /**
     * @return Site
     */
    public function getSite(): Site
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

    /**
     * @return int
     */
    public function getNo(): int
    {
        return $this->no;
    }

    /**
     * @param int $no
     */
    public function setNo(int $no): void
    {
        $this->no = $no;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return VocSType
     */
    public function getType(): VocSType
    {
        return $this->type;
    }

    /**
     * @param VocSType $type
     */
    public function setType(VocSType $type): void
    {
        $this->type = $type;
    }

    /**
     * Override site using the bucket one
     * @ORM\PrePersist
     * @param LifecycleEventArgs $event
     */
    public function setSiteByBucket(LifecycleEventArgs $event)
    {
        $finding = $event->getEntity();
        $this->site = $finding->getBucket()->getContext()->getSite();
    }

}