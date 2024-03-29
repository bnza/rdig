<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/05/18
 * Time: 9.15
 */

namespace App\Entity\Main;

use App\Exceptions\CrudException;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *
 * @ORM\Table(name="sample", uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"campaign", "no"})
 * })
 *
 * @UniqueEntity(
 *      fields={"campaign", "no"},
 *      errorPath="no",
 *      message="Duplicate registration number [{{ value }}] for this campaign "
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\SampleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Sample extends AbstractFinding
{
    /**
     * @var Campaign
     * @ORM\ManyToOne(targetEntity="Campaign")
     * @ORM\JoinColumn(name="campaign", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $campaign;

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
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $retrievalDate;

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

    public function getRetrievalDate(): \DateTime
    {
        return $this->retrievalDate;
    }

    /**
     * @param string|\DateTime $retrievalDate
     * @throws CrudException
     */
    public function setRetrievalDate($retrievalDate): void
    {
        if ($retrievalDate && is_string($retrievalDate)) {
            $retrievalDateString = $retrievalDate;
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2}$/', $retrievalDate)) {

                $retrievalDate = \DateTime::createFromFormat('d/m/y', $retrievalDateString);
                if (!$retrievalDate) {
                    throw new CrudException("Invalid date format ($retrievalDateString)");
                }
            } else if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $retrievalDate)) {
                $retrievalDate = \DateTime::createFromFormat('d/m/Y', $retrievalDateString);
                if (!$retrievalDate) {
                    throw new CrudException("Invalid date format ($retrievalDateString)");
                }
            } else if (preg_match('/^\d{4}$/', $retrievalDate)) {
                $retrievalDate = null;
            } else {
                try {
                    $retrievalDate = new \DateTime($retrievalDateString);
                } catch (\Exception $e) {
                    throw new CrudException("Invalid date format ($retrievalDateString)");
                }
            }

        }
        $this->retrievalDate = $retrievalDate ? $retrievalDate: null;
    }

    /**
     * Override site using the bucket one
     * @ORM\PrePersist
     * @param LifecycleEventArgs $event
     */
    public function setCampaignByBucket(LifecycleEventArgs $event)
    {
        if (!isset($this->campaign)) {
            $finding = $event->getEntity();
            $this->campaign = $finding->getBucket()->getCampaign();
        }
    }

}
