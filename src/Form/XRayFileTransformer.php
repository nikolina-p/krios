<?php

namespace App\Form;

use App\Entity\XRayFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class XRayFileTransformer implements DataTransformerInterface
{

    /**
     * Transforms an array of Photos to an array of UploadedFile objects.
     *
     */
    public function transform($xRayFile): ?UploadedFile
    {
        return $xRayFile->getXRayFile();
    }

    /**
     * Transforms a UploadedFile to a Photo.
     *
     */
    public function reverseTransform($uploadedFile): ?XRayFile
    {
        $xRayFile = new XRayFile();
        return $xRayFile->setXRayFile($uploadedFile);
    }
}
