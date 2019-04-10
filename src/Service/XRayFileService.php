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

    public function uploadXRayFiles(ArrayCollection $xRayFiles): void
    {
        foreach ($xRayFiles as $file) {
            if ($file->getXRayFile() != null) {
                $fileName = $this->xRayFileManager->upload($file->getXRayFile());
                $file->setFileName($fileName);
            }
        }
    }

    public function deleteXRayFile(string $fileName): void
    {
        $file = $this->xRayFileRepository->findOneBy(['fileName' => $fileName]);
        $this->xRayFileManager->deleteFile($file->getFileName());
        $this->xRayFileRepository->delete($file);
    }
}