<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\XRayFileRepository")
 */
class XRayFile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="xRayFile")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @var UploadedFile
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "The file is too large. Max 2M allowed"
     * )
     */
    private $xRayFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getXRayFile(): ?UploadedFile
    {
        return $this->xRayFile;
    }

    /**
     * @param UploadedFile $xRayFile
     * @return XRayFile
     */
    public function setXRayFile(UploadedFile $xRayFile): self
    {
        $this->xRayFile = $xRayFile;
        return $this;
    }
}
