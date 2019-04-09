<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Form\PatientForm;
use App\Repository\PatientRepository;

class PatientService
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
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
}
