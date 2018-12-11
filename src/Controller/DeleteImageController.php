<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteImageController
{
    private $imageRepository;
    private $trickRepository;
    private $manager;

    public function __construct(
        ImageRepository $imageRepository,
        TrickRepository $trickRepository,
        ObjectManager $manager
    )
    {
        $this->imageRepository = $imageRepository;
        $this->trickRepository = $trickRepository;
        $this->manager = $manager;
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

        // Trick
        $trick->removeImage($image);
        $this->trickRepository->save();

        // Image
        $this->imageRepository->remove($image);
        $this->imageRepository->save();

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