<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository"))
 */
class Photo
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
     * @ORM\Column(type="string")
     * @var string
     */
    private $archiveId;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $text;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $year;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $priceDescription;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="photos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $project;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $position;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $image;

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
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

        /**
     * @return string
     */
    public function getArchiveId()
    {
        return $this->archiveId;
    }

    /**
     * @param string $archiveId
     */
    public function setArchiveId(string $archiveId)
    {
        $this->archiveId = $archiveId;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getPriceDescription()
    {
        return $this->priceDescription;
    }

    /**
     * @param string $priceDescription
     */
    public function setPriceDescription(string $priceDescription)
    {
        $this->priceDescription = $priceDescription;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }



    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param int $project
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position)
    {
        $this->position = $position;
    }


    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }




}