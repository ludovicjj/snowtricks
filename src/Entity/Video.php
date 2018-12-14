<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Video
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $idVideo;

    /**
     * @var string
     */
    private $url;

    /**
     * @var Trick
     */
    private $trick;

    /**
     * Video constructor.
     * @param string $type
     * @param string $idVideo
     * @param string $url
     * @throws \Exception
     */
    public function __construct(
        string $type,
        string $idVideo,
        string $url
    )
    {
        $this->id = Uuid::uuid4();
        $this->type = $type;
        $this->idVideo = $idVideo;
        $this->url = $url;
    }


    private function url()
    {
        $control = $this->getType();  // on récupère le type de la vidéo
        $idVideo = strip_tags($this->getIdVideo()); // on récupère son identifiant

        if($control == 'youtube')
        {
            $embed = "https://www.youtube-nocookie.com/embed/".$idVideo;
            return $embed;
        }
        else if ($control == 'dailymotion')
        {
            $embed = "https://www.dailymotion.com/embed/video/".$idVideo;
            return $embed;
        }
        return null;
    }

    public function getIframe()
    {
        $iframe = "<iframe width='100%' height='100%' src='".$this->url()."'  frameborder='0'  allowfullscreen></iframe>";
        return $iframe;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIdVideo(): string
    {
        return $this->idVideo;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function definedTrick(Trick $trick)
    {
        $this->trick = $trick;
    }

    public function getTrick()
    {
        return $this->trick;
    }
}