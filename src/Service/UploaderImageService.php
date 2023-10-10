<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderImageService
{
    public function __construct(
        private readonly string $targetDirecotory,
        private readonly SluggerInterface $slugger
    ){
    }

    public function uploade(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilenae = $this->slugger->slug($originalFilename);

        $filename = $safeFilenae .'-' .uniqid() .'.'. $file->guessExtension();

        try {
            $file->move($this->getTargetDirecotory(), $filename);
        } catch (FileException $e) {
            // Erreur upload
        }

        return $filename;
    }

    private function getTargetDirecotory(): string
    {
        return $this->targetDirecotory;
    }
}