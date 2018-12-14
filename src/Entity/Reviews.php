<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewsRepository")
 */
class Reviews
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="text",type="text")
     */
    protected $text;

    /**
     * @var \DateTime
     * @ORM\Column(name="date",type="datetime")
     */
    protected $date;

    /**
     * @var Profile
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var Profile
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile")
     * @ORM\JoinColumn(name="profile", referencedColumnName="id")
     */
    protected $profile;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Profile
     */
    public function getAuthor(): Profile
    {
        return $this->author;
    }

    /**
     * @param Profile $author
     */
    public function setAuthor(Profile $author): void
    {
        $this->author = $author;
    }

    /**
     * @return Profile
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     */
    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
}
