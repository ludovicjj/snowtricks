<?php

namespace App\Service;


use App\DTO\VideoDTO;

class VideoUploader
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $idVideo;

    /**
     * @param VideoDTO $videoDTO
     * @return array
     */
    public function getVideoInfo(VideoDTO $videoDTO): array
    {
        $this->url = $videoDTO->url;

        if (preg_match("#^(http|https)://www.youtube.com/#", $this->url))
        {
            $this->youtubeId($this->url);

        }
        else if((preg_match("#^(http|https)://www.dailymotion.com/#", $this->url)))
        {
            $this->dailymotionId($this->url);
        }

        return [
            'url' => $this->url,
            'type' => $this->type,
            'idVideo' => $this->idVideo
        ];
    }


    private function youtubeId($url)
    {
        $tableaux = explode("=", $url);  // découpe l’url en deux  avec le signe ‘=’
        $this->idVideo = $tableaux[1];  // id de la video youtube
        $this->type = 'youtube';  // signale qu’il s’agit d’une video youtube
    }


    private function dailymotionId($url)
    {
        $cas = explode("/", $url); // On sépare la première partie de l'url des 2 autres
        $this->idVideo = $cas[4];  // id de la video dailymotion
        $this->type = 'dailymotion'; // signale qu’il s’agit d’une video dailymotion
    }
}