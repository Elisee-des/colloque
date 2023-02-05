<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderService {

    private $directory;

    private $images_directory;

    public function __construct($images_directory)
    {
        $this->directory = $images_directory;
        
    }
    
    public function uploader(UploadedFile $fichier, $nom=null)
    {
        if (!$nom) {
            $nom = uniqid();
        }

        $nouveauNom = $nom.".".$fichier->guessExtension();
        $fichier->move($this->directory, $nouveauNom);

        return $nouveauNom;
    }
}