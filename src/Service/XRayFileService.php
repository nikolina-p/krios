<?php

namespace App\Service;

use App\Entity\XRayFile;
use App\Repository\XRayFileRepository;

class XRayFileService
{
    private $xRayFileManager;

    private $xRayFileRepository;

    public function __construct(XRayFileManager $xRayFileManager, XRayFileRepository $xRayFileRepository)
    {
        $this->xRayFileManager = $xRayFileManager;
        $this->xRayFileRepository = $xRayFileRepository;
    }

    public function uploadXRayFile(XRayFile $xRayFile): void
    {
        $maxFileId = $this->getLastFileId();

        if ($xRayFile->getXRayFile() != null) {
            $maxFileId++;
            $fileName = $this->xRayFileManager->upload(
                $xRayFile->getXRayFile(),
                $xRayFile->getPatient()->getName().'_'.$xRayFile->getPatient()->getSurname().'_'.$maxFileId );
            $xRayFile->setFileName($fileName);
        }

        $this->xRayFileRepository->persist($xRayFile);
    }

    public function deleteXRayFile(int $id): void
    {
        $file = $this->xRayFileRepository->findOneBy(['id' => $id]);
        $this->xRayFileManager->deleteFile($file->getFileName());
        $this->xRayFileRepository->delete($file);
    }

    public function getLastFileId(): int
    {
        $lastRow = $this->xRayFileRepository->findOneBy([], [
            'id' => 'desc'
        ]);

        return !is_null($lastRow) ? $lastRow->getId() : 0;
    }
}
