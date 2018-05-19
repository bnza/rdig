<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectRepository")
 */
class Object extends AbstractFinding
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
    private $height;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $length;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $width;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $thickness;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $diameter;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $perforationDiameter;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $weigth;

    /**
     * @var VocOClass
     * @ORM\ManyToOne(targetEntity="VocOClass")
     * @ORM\JoinColumn(name="class", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $class;

    /**
     * @var VocOMaterialClass
     * @ORM\ManyToOne(targetEntity="VocOMaterialClass")
     * @ORM\JoinColumn(name="material_class", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $materialClass;

    /**
     * @var VocOMaterialType
     * @ORM\ManyToOne(targetEntity="VocOMaterialType")
     * @ORM\JoinColumn(name="material_type", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $materialType;

    /**
     * @var VocOTechnique
     * @ORM\ManyToOne(targetEntity="VocOTechnique")
     * @ORM\JoinColumn(name="technique", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $technique;

    /**
     * @var VocOType
     * @ORM\ManyToOne(targetEntity="VocOType")
     * @ORM\JoinColumn(name="type", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @ORM\JoinColumn(name="sub_type", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $subType;

    /**
     * @var VocFColor
     * @ORM\ManyToOne(targetEntity="VocFColor")
     * @ORM\JoinColumn(name="color", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $color;

    /**
     * @var VocOPreservation
     * @ORM\ManyToOne(targetEntity="VocOPreservation")
     * @ORM\JoinColumn(name="preservation", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $preservation;

    /**
     * @var VocODecoration
     * @ORM\ManyToOne(targetEntity="VocODecoration")
     * @ORM\JoinColumn(name="decoration", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $decoration;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $retrievalDate;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $inscription;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @param string $height
     */
    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getLength(): string
    {
        return $this->length;
    }

    /**
     * @param string $length
     */
    public function setLength(string $length): void
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @param string $width
     */
    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    /**
     * @return string
     */
    public function getThickness(): string
    {
        return $this->thickness;
    }

    /**
     * @param string $thickness
     */
    public function setThickness(string $thickness): void
    {
        $this->thickness = $thickness;
    }

    /**
     * @return string
     */
    public function getDiameter(): string
    {
        return $this->diameter;
    }

    /**
     * @param string $diameter
     */
    public function setDiameter(string $diameter): void
    {
        $this->diameter = $diameter;
    }

    /**
     * @return string
     */
    public function getPerforationDiameter(): string
    {
        return $this->perforationDiameter;
    }

    /**
     * @param string $perforationDiameter
     */
    public function setPerforationDiameter(string $perforationDiameter): void
    {
        $this->perforationDiameter = $perforationDiameter;
    }

    /**
     * @return string
     */
    public function getWeigth(): string
    {
        return $this->weigth;
    }

    /**
     * @param string $weigth
     */
    public function setWeigth(string $weigth): void
    {
        $this->weigth = $weigth;
    }

    /**
     * @return VocOClass
     */
    public function getClass(): VocOClass
    {
        return $this->class;
    }

    /**
     * @param VocOClass $class
     */
    public function setClass(VocOClass $class): void
    {
        $this->class = $class;
    }

    /**
     * @return VocOMaterialClass
     */
    public function getMaterialClass(): VocOMaterialClass
    {
        return $this->materialClass;
    }

    /**
     * @param VocOMaterialClass $materialClass
     */
    public function setMaterialClass(VocOMaterialClass $materialClass): void
    {
        $this->materialClass = $materialClass;
    }

    /**
     * @return VocOMaterialType
     */
    public function getMaterialType(): VocOMaterialType
    {
        return $this->materialType;
    }

    /**
     * @param VocOMaterialType $materialType
     */
    public function setMaterialType(VocOMaterialType $materialType): void
    {
        $this->materialType = $materialType;
    }

    /**
     * @return VocOTechnique
     */
    public function getTechnique(): VocOTechnique
    {
        return $this->technique;
    }

    /**
     * @param VocOTechnique $technique
     */
    public function setTechnique(VocOTechnique $technique): void
    {
        $this->technique = $technique;
    }

    /**
     * @return VocOType
     */
    public function getType(): VocOType
    {
        return $this->type;
    }

    /**
     * @param VocOType $type
     */
    public function setType(VocOType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSubType(): string
    {
        return $this->subType;
    }

    /**
     * @param string $subType
     */
    public function setSubType(string $subType): void
    {
        $this->subType = $subType;
    }

    /**
     * @return VocFColor
     */
    public function getColor(): VocFColor
    {
        return $this->color;
    }

    /**
     * @param VocFColor $color
     */
    public function setColor(VocFColor $color): void
    {
        $this->color = $color;
    }

    /**
     * @return VocOPreservation
     */
    public function getPreservation(): VocOPreservation
    {
        return $this->preservation;
    }

    /**
     * @param VocOPreservation $preservation
     */
    public function setPreservation(VocOPreservation $preservation): void
    {
        $this->preservation = $preservation;
    }

    /**
     * @return \DateTime
     */
    public function getRetrievalDate(): \DateTime
    {
        return $this->retrievalDate;
    }

    /**
     * @param string|\DateTime $retrievalDate
     */
    public function setRetrievalDate($retrievalDate): void
    {
        if (is_string($retrievalDate)) {
            $retrievalDate = \DateTime::createFromFormat('d/m/Y', $retrievalDate);
        }
        $this->retrievalDate = $retrievalDate;
    }

    /**
     * @return string
     */
    public function getInscription(): string
    {
        return $this->inscription;
    }

    /**
     * @param string $inscription
     */
    public function setInscription(string $inscription): void
    {
        $this->inscription = $inscription;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return VocODecoration
     */
    public function getDecoration(): VocODecoration
    {
        return $this->decoration;
    }

    /**
     * @param VocODecoration $decoration
     */
    public function setDecoration(VocODecoration $decoration): void
    {
        $this->decoration = $decoration;
    }

}