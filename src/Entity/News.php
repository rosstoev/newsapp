<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @ORM\Column(type="string", length=500, name="sh_content")
     * @var string
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $content;
    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="categoryNews")
     * @ORM\JoinTable(name="news_groups",
     *     joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
        private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="createdNews")
     *
     */
    private $author;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->dateAdded =  new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     * @return News
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }


    public function getSummary()
    {
        if($this->summary === null){
            $this->setSummary();
        }

        return $this->summary;
    }


    public function setSummary()
    {
        return $this->summary = substr($this->getContent(),0,strlen($this->getContent())/5);
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }


    /**
     * @param User|null $author
     * @return News
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdded(): \DateTime
    {
        return $this->dateAdded;
    }

    /**
     *
     * @ORM\PreUpdate
     */
    public function setDateAdded()
    {
        $this->dateAdded = new \DateTime("now");

    }



}
