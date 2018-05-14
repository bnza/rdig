<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/05/18
 * Time: 9.15
 */

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SampleRepository")
 */
class Sample extends AbstractFinding
{
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
     */
    private $type;

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
    public function setStatus(string $status): void
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

}