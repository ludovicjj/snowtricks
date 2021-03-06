<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Service\Slugger;
use Doctrine\Common\Collections\ArrayCollection;

class Trick
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var ArrayCollection
     */
    private $images;

    /**
     * @var ArrayCollection
     */
    private $videos;

    /**
     * @var ArrayCollection
     */
    private $comments;

    /**
     * @var int
     */
    private $nbComments;

    /**
     * Trick constructor.
     * @param string $title
     * @param string $description
     * @param string $slug
     * @param Category $category
     * @param array $images
     * @param array $videos
     * @throws \Exception
     */
    public function __construct(
        string $title,
        string $description,
        string $slug,
        Category $category,
        array $images = [],
        array $videos = []
    )
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
        $this->description = $description;
        $this->slug = Slugger::slug($slug);
        $this->createdAt = new \DateTime();
        $this->category = $category;
        $this->images = new ArrayCollection($images);
        $this->videos = new ArrayCollection($videos);
        $this->comments = new ArrayCollection();
        $this->nbComments = 0;

        // Liaison trick-Video
        foreach ($videos as $video) {
            $video->definedTrick($this);
        }
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $slug
     * @param Category $category
     * @param array|null $images
     * @param array|null $videos
     * @throws \Exception
     */
    public function update(
        string $title,
        string $description,
        string $slug,
        Category $category,
        array $images = null,
        array $videos = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->slug = Slugger::Slug($slug);
        $this->updatedAt = new \DateTime();
        $this->category = $category;
        $this->addImage($images);
        $this->addVideos($videos);
    }

    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }

    public function addVideos(array $videos)
    {
        foreach ($videos as $video) {
            $video->definedTrick($this);
            $this->videos[] = $video;
        }
    }

    public function addImage($images)
    {
        foreach ($images as $image) {
            $this->images[] = $image;
        }
    }

    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    public function increaseComment(): void
    {
        $this->nbComments++;
    }


    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getVideos()
    {
        return $this->videos;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getNbComments(): int
    {
        return $this->nbComments;
    }
}