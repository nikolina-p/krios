<?php

namespace App\Service;

use App\Entity\Patient;
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
}
