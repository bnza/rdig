<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $height;

    /**
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $length;

    /**
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $width;

    /**
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $thickness;

    /**
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $diameter;

    /**
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $perforationDiameter;

    /**
     * @var float
     * @Assert\Type("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

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
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $drawing;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $photo;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $envanterlik;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $etutluk;

    /**
     * @return bool
     */
    public function isDrawing(): bool
    {
        return $this->drawing;
    }

    /**
     * @param mixed $drawing
     */
    public function setDrawing($drawing): void
    {
        $this->drawing = (bool) $drawing;
    }

    /**
     * @return bool
     */
    public function getPhoto(): bool
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = (bool) $photo;
    }

    /**
     * @return bool
     */
    public function getEnvanterlik(): bool
    {
        return $this->envanterlik;
    }

    /**
     * @param mixed $envanterlik
     */
    public function setEnvanterlik($envanterlik): void
    {
        $this->envanterlik = (bool) $envanterlik;
    }

    /**
     * @return bool
     */
    public function getEtutluk(): bool
    {
        return $this->etutluk;
    }

    /**
     * @param mixed $etutluk
     */
    public function setEtutluk($etutluk): void
    {
        $this->etutluk = (bool) $etutluk;
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
    public function setNo($no): void
    {
        $this->no = $no;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $this->castNumeric($height, 'float');
    }

    /**
     * @return float
     */
    public function getLength(): float
    {
        return $this->length;
    }

    /**
     * @param $length
     */
    public function setLength($length): void
    {
        $this->length = $this->castNumeric($length, 'float');
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = $this->castNumeric($width, 'float');
    }

    /**
     * @return float
     */
    public function getThickness(): float
    {
        return $this->thickness;
    }

    /**
     * @param float $thickness
     */
    public function setThickness($thickness)
    {
        $this->thickness = $this->castNumeric($thickness, 'float');
    }

    /**
     * @return float
     */
    public function getDiameter(): float
    {
        return $this->diameter;
    }

    /**
     * @param float $diameter
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $this->castNumeric($diameter, 'float');
    }

    /**
     * @return float
     */
    public function getPerforationDiameter(): float
    {
        return $this->perforationDiameter;
    }

    /**
     * @param mixed $perforationDiameter
     */
    public function setPerforationDiameter($perforationDiameter)
    {
        $this->perforationDiameter = $this->castNumeric($perforationDiameter, 'float');
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $this->castNumeric($weight, 'float');;
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
        $this->retrievalDate = $retrievalDate ? $retrievalDate: null;
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