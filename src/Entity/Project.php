<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository"))
 */
class Project
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(length=128, unique=true)
     * @var string
     */
    private $slug;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="project")
     */
    private $photos;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $position;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $thumbnail
     */
    public function setImage($image)
    {
        $this->image = $image;

    }

    /**
     * @return Collection|Product[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }


    public function __toString():string
    {
        return $this->getId();
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }


}