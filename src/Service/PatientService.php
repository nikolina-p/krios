<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Form\PatientForm;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;

class PatientService
{
    private $patientRepository;
    private $xRayFileService;

    public function __construct(PatientRepository $patientRepository, XRayFileService $xRayFileService)
    {
        $this->patientRepository = $patientRepository;
        $this->xRayFileService = $xRayFileService;
    }

    public function findAll(): array
    {
        return $this->patientRepository->findAll();
    }

    public function newPatient(Patient $patient): void
    {
        $this->patientRepository->persist($patient);
    }

    public function saveChanges(Patient $patient): void
    {
        $this->patientRepository->persist($patient);
    }

    public function searchPatients(PatientDTO $patientDTO): array
    {
        return $this->patientRepository->searchPatients($patientDTO->getSearchTerm());
    }

    public function uploadFile(Patient $patient)
    {
        $this->xRayFileService->uploadXRayFiles($patient->getXRayFile());
    }
}
