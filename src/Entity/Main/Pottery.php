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
 * @ORM\Entity
 */
class Pottery extends AbstractFinding
{
    /**
     * @var VocPClass
     * @ORM\ManyToOne(targetEntity="VocPClass")
     */
    private $class;

    /**
     * @var VocPPreservation
     * @ORM\ManyToOne(targetEntity="VocPPreservation")
     */
    private $preservation;

    /**
     * @var VocPTechnique
     * @ORM\ManyToOne(targetEntity="VocPTechnique")
     */
    private $technique;

    /**
     * @var VocPShape
     * @ORM\ManyToOne(targetEntity="VocPShape")
     */
    private $shape;

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

}