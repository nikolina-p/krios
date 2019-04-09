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
    public function transform($xRayFiles): ?ArrayCollection
    {
        if (count($xRayFiles) == 0) {
            return null;
        }
        return $xRayFiles->unwrap();
    }

    /**
     * Transforms a UploadedFile to a Photo.
     *
     */
    public function reverseTransform($uploadedFiles): ?ArrayCollection
    {
        array_walk($uploadedFiles, function (&$file) {
            $xRayFile = new XRayFile();
            $file = $xRayFile->setXRayFile($file);
        });

        return new ArrayCollection($uploadedFiles);
    }
}
