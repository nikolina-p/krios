<?php

namespace App\Service;

use App\Entity\XRayFile;
use App\Repository\XRayFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints\Collection;

class XRayFileService
{
    private $xRayFileManager;

    private $xRayFileRepository;

    public function __construct(XRayFileManager $xRayFileManager, XRayFileRepository $xRayFileRepository)
    {
        $this->xRayFileManager = $xRayFileManager;
        $this->xRayFileRepository = $xRayFileRepository;
    }

    public function uploadXRayFiles(ArrayCollection $xRayFiles, string $patientName, int $maxFileId): void
    {
        foreach ($xRayFiles as $file) {
            if ($file->getXRayFile() != null) {
                $maxFileId++;
                $fileName = $this->xRayFileManager->upload($file->getXRayFile(), $patientName.'_'.$maxFileId );
                $file->setFileName($fileName);
            }
        }
    }

    public function deleteXRayFile(int $id): void
    {
        $file = $this->xRayFileRepository->findOneBy(['id' => $id]);
        $this->xRayFileManager->deleteFile($file->getFileName());
        $this->xRayFileRepository->delete($file);
    }

    public function getLastFileId(): int
    {
        return $this->xRayFileRepository
            ->findOneBy([], ['id' => 'desc'])
            ->getId();
    }
}
