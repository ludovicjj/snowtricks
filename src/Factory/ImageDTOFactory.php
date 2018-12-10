<?php

namespace App\Factory;

use App\DTO\ImageDTO;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;

class ImageDTOFactory
{
    public function create(Image $image)
    {
        // Hydratation de ImageDTO avec des objets File

        return new ImageDTO(
            // Problème:
            // Si j'indique le chemin absolu de l'image, {{ asset(path) }} ne parviens pas a afficher l'image
            // si j'indique uniquement le chemin depuis le repertoire "/public" SF me renvoi file doest exist
            // Solution:
            // Definir le 2eme paramètre du constructeur de la class File à false.
            // Ne retourne plus la verification si le file n'existe pas.
            new File($image->getPath(),false)
        );
    }
}