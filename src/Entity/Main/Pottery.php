<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $baseDiameter;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $baseHeight;


    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $baseWidth;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $height;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $maxWallDiameter;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $rimDiameter;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $rimWidth;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $wallWidth;

    /**
     * @return string
     */
    public function getRimDiameter(): string
    {
        return $this->rimDiameter;
    }

    /**
     * @param string $rimDiameter
     */
    public function setRimDiameter(string $rimDiameter): void
    {
        $this->rimDiameter = $rimDiameter;
    }

    /**
     * @return string
     */
    public function getRimWidth(): string
    {
        return $this->rimWidth;
    }

    /**
     * @param string $rimWidth
     */
    public function setRimWidth(string $rimWidth): void
    {
        $this->rimWidth = $rimWidth;
    }

    /**
     * @return string
     */
    public function getWallWidth(): string
    {
        return $this->wallWidth;
    }

    /**
     * @param string $wallWidth
     */
    public function setWallWidth(string $wallWidth): void
    {
        $this->wallWidth = $wallWidth;
    }

    /**
     * @return string
     */
    public function getMaxWallDiameter(): string
    {
        return $this->maxWallDiameter;
    }

    /**
     * @param string $maxWallDiameter
     */
    public function setMaxWallDiameter(string $maxWallDiameter): void
    {
        $this->maxWallDiameter = $maxWallDiameter;
    }

    /**
     * @return string
     */
    public function getBaseWidth(): string
    {
        return $this->baseWidth;
    }

    /**
     * @param string $baseWidth
     */
    public function setBaseWidth(string $baseWidth): void
    {
        $this->baseWidth = $baseWidth;
    }

    /**
     * @return string
     */
    public function getBaseHeight(): string
    {
        return $this->baseHeight;
    }

    /**
     * @param string $baseHeight
     */
    public function setBaseHeight(string $baseHeight): void
    {
        $this->baseHeight = $baseHeight;
    }

    /**
     * @return string
     */
    public function getBaseDiameter(): string
    {
        return $this->baseDiameter;
    }

    /**
     * @param string $baseDiameter
     */
    public function setBaseDiameter(string $baseDiameter): void
    {
        $this->baseDiameter = $baseDiameter;
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
    public function setFiring(VocPFiring $firing): void
    {
        $this->firing = $firing;
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
    public function setHeight(string $height)
    {
        $this->height = $height;
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
    public function setClass(VocPClass $class): void
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
    public function setCoreColor(VocFColor $coreColor): void
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
    public function setInnerColor(VocFColor $innerColor): void
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
    public function setOuterColor(VocFColor $outerColor): void
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
    public function setInnerDecoration(VocPDecoration $innerDecoration): void
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
    public function setInclusionsFrequency(VocPInclusionsFrequency $inclusionFrequency): void
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
    public function setInclusionsSize(VocPInclusionsSize $inclusionsSize): void
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
    public function setInclusionsType(VocPInclusionsType $inclusionsType): void
    {
        $this->inclusionsType = $inclusionsType;
    }

    /**
     * @param VocPDecoration $outerDecoration
     */
    public function setOuterDecoration(VocPDecoration $outerDecoration): void
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
    public function setPreservation(VocPPreservation $preservation): void
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
    public function setShape(VocPShape $shape): void
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
    public function setTechnique(VocPTechnique $technique): void
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
    public function setInnerSurfaceTreatment(VocPSurfaceTreatment $innerSurfaceTreatment): void
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
    public function setOuterSurfaceTreatment(VocPSurfaceTreatment $outerSurfaceTreatment): void
    {
        $this->outerSurfaceTreatment = $outerSurfaceTreatment;
    }

}