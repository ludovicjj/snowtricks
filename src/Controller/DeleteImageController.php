<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Service\FileDelete;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteImageController
{
    private $imageRepository;
    private $trickRepository;
    private $fileDelete;

    public function __construct(
        ImageRepository $imageRepository,
        TrickRepository $trickRepository,
        FileDelete $fileDelete
    )
    {
        $this->imageRepository = $imageRepository;
        $this->trickRepository = $trickRepository;
        $this->fileDelete = $fileDelete;
    }

    /**
     * @Route("/delete/image/{id_image}/{id_trick}", methods="DELETE", name="delete_images")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        /* @var \App\Entity\Image $image */
        $image = $this->imageRepository->findOneBy(['id' => $request->attributes->get('id_image')]);
        /* @var \App\Entity\Trick $trick */
        $trick = $this->trickRepository->findOneBy(['id' => $request->attributes->get('id_trick')]);

        // Clean table "trick" and table d'assosiation "tricks_images (cascade)
        $trick->removeImage($image);
        $this->trickRepository->save();

        // Supprime l'image et clean la table "image"
        $this->fileDelete->delete($image);
        $this->imageRepository->remove($image);

        return new Response(
            json_encode(
                [
                    'type' => 'success',
                    'message' => 'L\'image a été supprimé'
                ]
            ), Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}