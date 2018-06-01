<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/05/18
 * Time: 11.29
 */

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true, repositoryClass="App\Repository\FindingRepository")
 * @ORM\Table(name="vw_finding")
 */
class Finding implements SiteRelateEntityInterface
{
    private function __construct() {}

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Bucket
     * Many Buckets have One Campaign.
     * @ORM\ManyToOne(targetEntity="Bucket", inversedBy="findings")
     * @ORM\JoinColumn(name="bucket", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $bucket;

    /**
     * @ORM\Column(type="string", length=4, nullable=false))
     */
    private $num;

    /**
     * @ORM\Column(type="text")
     */
    private $remarks;

    /**
     * @var VocFChronology
     * @ORM\ManyToOne(targetEntity="VocFChronology")
     * @ORM\JoinColumn(name="chronology", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $chronology;

    /**
     * @ORM\Column(type="text", name="discr")
     */
    private $group;

    /**
     * @return VocFChronology
     */
    public function getChronology(): VocFChronology
    {
        return $this->chronology;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @return mixed
     */
    public function getNum()
    {
        return $this->num;
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
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
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
            'id' => '@TODO'
        ];
    }

}