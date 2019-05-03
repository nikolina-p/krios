<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\XRayFile", mappedBy="patient", orphanRemoval=true,
     *     cascade={"persist", "remove"})
     */
    private $xRayFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    public function __construct()
    {
        $this->xRayFile = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getXRayFile(): ?Collection
    {
        return $this->xRayFile;
    }

    public function addXRayFile(XRayFile $xRayFile): self
    {
        if (!$this->xRayFile->contains($xRayFile)) {
            $xRayFile->setPatient($this);
            $this->xRayFile[] = $xRayFile;
        }

        return $this;
    }

    public function removeXRayFile(XRayFile $xRayFile): self
    {
        if ($this->xRayFile->contains($xRayFile)) {
            $this->xRayFile->removeElement($xRayFile);
            // set the owning side to null (unless already changed)
            if ($xRayFile->getPatient() === $this) {
                $xRayFile->setPatient(null);
            }
        }

        return $this;
    }

    public function setXRayFiles(ArrayCollection $files): void
    {
        $this->xRayFile = $files;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getPrettyRegistrationDate(): string
    {
        if ($this->registrationDate === null) {
            return 'unknown';
        }

        return $this->registrationDate->format('d M Y');
    }
}
