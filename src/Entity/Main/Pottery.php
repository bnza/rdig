<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PotteryRepository")
 */
class Pottery extends AbstractFinding
{
    /**
     * @var VocPClass
     * @ORM\ManyToOne(targetEntity="VocPClass")
     * @ORM\JoinColumn(name="class", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $class;

    /**
     * @var VocFColor
     * @ORM\ManyToOne(targetEntity="VocFColor")
     * @ORM\JoinColumn(name="core_color", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $coreColor;

    /**
     * @var VocPFiring
     * @ORM\ManyToOne(targetEntity="VocPFiring")
     * @ORM\JoinColumn(name="firing", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $firing;

    /**
     * @var VocPInclusionsFrequency
     * @ORM\ManyToOne(targetEntity="VocPInclusionsFrequency")
     * @ORM\JoinColumn(name="inclusions_frequency", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $inclusionsFrequency;

    /**
     * @var VocPInclusionsSize
     * @ORM\ManyToOne(targetEntity="VocPInclusionsSize")
     * @ORM\JoinColumn(name="inclusions_size", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $inclusionsSize;

    /**
     * @var VocPInclusionsType
     * @ORM\ManyToOne(targetEntity="VocPInclusionsType")
     */
    private $inclusionsType;

    /**
     * @var VocFColor
     * @ORM\ManyToOne(targetEntity="VocFColor")
     * @ORM\JoinColumn(name="inner_color", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $innerColor;

    /**
     * @var VocPDecoration
     * @ORM\ManyToOne(targetEntity="VocPDecoration")
     * @ORM\JoinColumn(name="inner_decoration", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $innerDecoration;

    /**
     * @var VocPSurfaceTreatment
     * @ORM\ManyToOne(targetEntity="VocPSurfaceTreatment")
     * @ORM\JoinColumn(name="inner_surface_treatment", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $innerSurfaceTreatment;

    /**
     * @var VocFColor
     * @ORM\ManyToOne(targetEntity="VocFColor")
     * @ORM\JoinColumn(name="outer_color", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $outerColor;

    /**
     * @var VocPDecoration
     * @ORM\ManyToOne(targetEntity="VocPDecoration")
     * @ORM\JoinColumn(name="inner_decoration", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $outerDecoration;

    /**
     * @var VocPSurfaceTreatment
     * @ORM\ManyToOne(targetEntity="VocPSurfaceTreatment")
     * @ORM\JoinColumn(name="outer_surface_treatment", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $outerSurfaceTreatment;

    /**
     * @var VocPPreservation
     * @ORM\ManyToOne(targetEntity="VocPPreservation")
     * @ORM\JoinColumn(name="preservation", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $preservation;

    /**
     * @var VocPShape
     * @ORM\ManyToOne(targetEntity="VocPShape")
     * @ORM\JoinColumn(name="shape", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $shape;

    /**
     * @var VocPTechnique
     * @ORM\ManyToOne(targetEntity="VocPTechnique")
     * @ORM\JoinColumn(name="technique", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $technique;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $baseDiameter;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $baseHeight;


    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $baseWidth;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $height;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $maxWallDiameter;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $rimDiameter;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $rimWidth;

    /**
     * @var float
     * @AppAssert\NullableType("float")
     * @ORM\Column(type="float", nullable=true)
     */
    private $wallWidth;

    /**
     * @var string
     * @AppAssert\NullableType("string")
     * @ORM\Column(type="string", nullable=true)
     */
    private $drawingNumber;

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
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $location;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $restored;

    /**
     * @return bool
     */
    public function isEnvanterlik(): bool
    {
        return $this->envanterlik;
    }

    /**
     * @param bool $envanterlik
     */
    public function setEnvanterlik($envanterlik): void
    {
        $this->envanterlik = (bool) $envanterlik;
    }

    /**
     * @return bool
     */
    public function isEtutluk(): bool
    {
        return $this->etutluk;
    }

    /**
     * @param bool $etutluk
     */
    public function setEtutluk($etutluk): void
    {
        $this->etutluk = (bool) $etutluk;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getDrawingNumber(): string
    {
        return $this->drawingNumber;
    }

    /**
     * @param string $drawingNumber
     */
    public function setDrawingNumber($drawingNumber): void
    {
        $drawingNumber = $drawingNumber === '' ? null : $drawingNumber;
        $this->drawingNumber = $drawingNumber;
    }

    /**
     * @return bool
     */
    public function isRestored(): bool
    {
        return $this->restored;
    }

    /**
     * @param $restored
     */
    public function setRestored($restored): void
    {
        $this->restored = (bool) $restored;
    }

    /**
     * @return float
     */
    public function getRimDiameter(): float
    {
        return $this->rimDiameter;
    }

    /**
     * @param float $rimDiameter
     */
    public function setRimDiameter($rimDiameter)
    {
        $this->rimDiameter = $this->castNumeric($rimDiameter, 'float');
    }

    /**
     * @return float
     */
    public function getRimWidth(): float
    {
        return $this->rimWidth;
    }

    /**
     * @param float $rimWidth
     */
    public function setRimWidth($rimWidth)
    {
        $this->rimWidth = $this->castNumeric($rimWidth, 'float');
    }

    /**
     * @return float
     */
    public function getWallWidth(): float
    {
        return $this->wallWidth;
    }

    /**
     * @param float $wallWidth
     */
    public function setWallWidth($wallWidth)
    {
        $this->wallWidth = $this->castNumeric($wallWidth, 'float');
    }

    /**
     * @return float
     */
    public function getMaxWallDiameter(): float
    {
        return $this->maxWallDiameter;
    }

    /**
     * @param float $maxWallDiameter
     */
    public function setMaxWallDiameter($maxWallDiameter)
    {
        $this->maxWallDiameter = $this->castNumeric($maxWallDiameter, 'float');
    }

    /**
     * @return float
     */
    public function getBaseWidth(): float
    {
        return $this->baseWidth;
    }

    /**
     * @param float $baseWidth
     */
    public function setBaseWidth($baseWidth)
    {
        $this->baseWidth = $this->castNumeric($baseWidth, 'float');
    }

    /**
     * @return float
     */
    public function getBaseHeight(): float
    {
        return $this->baseHeight;
    }

    /**
     * @param float $baseHeight
     */
    public function setBaseHeight($baseHeight)
    {
        $this->baseHeight = $this->castNumeric($baseHeight, 'float');
    }

    /**
     * @return float
     */
    public function getBaseDiameter(): float
    {
        return $this->baseDiameter;
    }

    /**
     * @param float $baseDiameter
     */
    public function setBaseDiameter($baseDiameter)
    {
        $this->baseDiameter = $this->castNumeric($baseDiameter, 'float');
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
        $this->height = $this->castNumeric($height, 'float');;
    }

    /**
     * @return VocPFiring
     */
    public function getFiring(): VocPFiring
    {
        return $this->firing;
    }

    /**
     * @param VocPFiring $firing
     */
    public function setFiring(VocPFiring $firing = null): void
    {
        $this->firing = $firing;
    }

    /**
     * @return VocPClass
     */
    public function getClass(): VocPClass
    {
        return $this->class;
    }

    /**
     * @param VocPClass $class
     */
    public function setClass(VocPClass $class = null): void
    {
        $this->class = $class;
    }

    /**
     * @return VocFColor
     */
    public function getCoreColor(): VocFColor
    {
        return $this->coreColor;
    }

    /**
     * @param VocFColor $coreColor
     */
    public function setCoreColor(VocFColor $coreColor = null): void
    {
        $this->coreColor = $coreColor;
    }

    /**
     * @return VocFColor
     */
    public function getInnerColor(): VocFColor
    {
        return $this->innerColor;
    }

    /**
     * @param VocFColor $innerColor
     */
    public function setInnerColor(VocFColor $innerColor = null): void
    {
        $this->innerColor = $innerColor;
    }

    /**
     * @return VocFColor
     */
    public function getOuterColor(): VocFColor
    {
        return $this->outerColor;
    }

    /**
     * @param VocFColor $outerColor
     */
    public function setOuterColor(VocFColor $outerColor = null): void
    {
        $this->outerColor = $outerColor;
    }

    /**
     * @return VocPDecoration
     */
    public function getInnerDecoration(): VocPDecoration
    {
        return $this->innerDecoration;
    }

    /**
     * @param VocPDecoration $innerDecoration
     */
    public function setInnerDecoration(VocPDecoration $innerDecoration = null): void
    {
        $this->innerDecoration = $innerDecoration;
    }

    /**
     * @return VocPDecoration
     */
    public function getOuterDecoration(): VocPDecoration
    {
        return $this->outerDecoration;
    }

    /**
     * @return VocPInclusionsFrequency
     */
    public function getInclusionsFrequency(): VocPInclusionsFrequency
    {
        return $this->inclusionsFrequency;
    }

    /**
     * @param VocPInclusionsFrequency $inclusionFrequency
     */
    public function setInclusionsFrequency(VocPInclusionsFrequency $inclusionFrequency = null): void
    {
        $this->inclusionsFrequency = $inclusionFrequency;
    }

    /**
     * @return VocPInclusionsSize
     */
    public function getInclusionsSize(): VocPInclusionsSize
    {
        return $this->inclusionsSize;
    }

    /**
     * @param VocPInclusionsSize $inclusionsSize
     */
    public function setInclusionsSize(VocPInclusionsSize $inclusionsSize = null): void
    {
        $this->inclusionsSize = $inclusionsSize;
    }

    /**
     * @return VocPInclusionsType
     */
    public function getInclusionsType(): VocPInclusionsType
    {
        return $this->inclusionsType;
    }

    /**
     * @param VocPInclusionsType $inclusionsType
     */
    public function setInclusionsType(VocPInclusionsType $inclusionsType = null): void
    {
        $this->inclusionsType = $inclusionsType;
    }

    /**
     * @param VocPDecoration $outerDecoration
     */
    public function setOuterDecoration(VocPDecoration $outerDecoration = null): void
    {
        $this->outerDecoration = $outerDecoration;
    }

    /**
     * @return VocPPreservation
     */
    public function getPreservation(): VocPPreservation
    {
        return $this->preservation;
    }

    /**
     * @param VocPPreservation $preservation
     */
    public function setPreservation(VocPPreservation $preservation = null): void
    {
        $this->preservation = $preservation;
    }

    /**
     * @return VocPShape
     */
    public function getShape(): VocPShape
    {
        return $this->shape;
    }

    /**
     * @param VocPShape $shape
     */
    public function setShape(VocPShape $shape = null): void
    {
        $this->shape = $shape;
    }

    /**
     * @return VocPTechnique
     */
    public function getTechnique(): VocPTechnique
    {
        return $this->technique;
    }

    /**
     * @param VocPTechnique $technique
     */
    public function setTechnique(VocPTechnique $technique = null): void
    {
        $this->technique = $technique;
    }

    /**
     * @return VocPSurfaceTreatment
     */
    public function getInnerSurfaceTreatment(): VocPSurfaceTreatment
    {
        return $this->innerSurfaceTreatment;
    }

    /**
     * @param VocPSurfaceTreatment $innerSurfaceTreatment
     */
    public function setInnerSurfaceTreatment(VocPSurfaceTreatment $innerSurfaceTreatment = null): void
    {
        $this->innerSurfaceTreatment = $innerSurfaceTreatment;
    }

    /**
     * @return VocPSurfaceTreatment
     */
    public function getOuterSurfaceTreatment(): VocPSurfaceTreatment
    {
        return $this->outerSurfaceTreatment;
    }

    /**
     * @param VocPSurfaceTreatment $outerSurfaceTreatment
     */
    public function setOuterSurfaceTreatment(VocPSurfaceTreatment $outerSurfaceTreatment = null): void
    {
        $this->outerSurfaceTreatment = $outerSurfaceTreatment;
    }

}