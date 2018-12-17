<?php

namespace App\Builder\Video;

use App\DTO\VideoDTO;
use App\Entity\Video;
use App\Repository\VideoRepository;

class VideoUpdateBuilder
{
    // temoi
    private $newUrl = [];
    private $oldUrl = [];

    /**
     * @var VideoBuilder
     */
    private $videoBuilder;

    /**
     * @var VideoRepository
     */
    private $videoRepository;

    public function __construct(
        VideoBuilder $videoBuilder,
        VideoRepository $videoRepository
    )
    {
        $this->videoBuilder = $videoBuilder;
        $this->videoRepository = $videoRepository;
    }

    /**
     * @param array $tableauVideoDTO
     * @param array $tableauVideo
     * @return array
     * @throws \Exception
     */
    public function compare(array $tableauVideoDTO, array $tableauVideo)
    {
        // Depart :
        // $tableauVideo : 2 index
        // $tableauVideoDTO : 2 index

        // a faire:
        // update : ok
        // add : ok
        // delete: ok

        foreach ($tableauVideoDTO as $key => $videoDTO ) {

            if (array_key_exists($key, $tableauVideo)) {
                $resulat = $this->compareUrl($tableauVideo[$key], $videoDTO);
                // Modification d'une Url
                // Video : 2 index
                // VideoDTO : 2 index (Modification)

                // if $resultat = true => modification
                // else $resultat = false => inchanger
                if ($resulat) {
                    // old url
                    $this->oldUrl[$key] = $tableauVideo[$key];
                    // new url
                    $this->newUrl[$key] = $videoDTO;
                }
            } else {
                // Video a 2 index
                // VideoDTO a 3 index
                // donc il y a un ajout
                $this->newUrl[$key] = $videoDTO;
            }
        }
        // Delete
        // Video à 2 index
        // VideoDTO n'a plus que 1 index
        // donc il y a un delete
        foreach ($tableauVideo as $key => $video) {
            if (!array_key_exists($key, $tableauVideoDTO)) {
                $this->oldUrl[$key] = $video;
            }
        }

        foreach ($this->oldUrl as $key => $video) {
            $this->videoRepository->remove($video);
        }

        $newVideoCollection = $this->videoBuilder->create($this->newUrl);

        return $newVideoCollection;
    }

    public function compareUrl(Video $video, VideoDTO $videoDTO): bool
    {
        if ($video->getUrl() == $videoDTO->url) {
            return false;
        } else {
            return true;
        }
    }
}