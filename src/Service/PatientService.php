<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Entity\XRayFile;
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

    public function saveChanges(): void
    {
        $this->patientRepository->saveChanges();
    }

    public function searchPatients(PatientDTO $patientDTO): array
    {
        return $this->patientRepository->searchPatients($patientDTO->getSearchTerm());
    }

    public function uploadFiles(Patient $patient)
    {
        $oldFiles = $patient->getXRayFile()->getSnapshot();
        foreach ($oldFiles as $file) {
            $patient->addXRayFile($file);
        }

        $maxFileId = $this->xRayFileService->getLastFileId();

        $this->xRayFileService->uploadXRayFiles(
            $patient->getXRayFile()->unwrap(),
            $patient->getName()."_".$patient->getSurname(),
            $maxFileId
        );

        $this->saveChanges();
    }

    public function deleteXRayFile(int $id)
    {
        $this->xRayFileService->deleteXRayFile($id);
    }
}
