<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{


    const SUPPLIER = 0;
    const CUSTOMER = 1;

    public static $types = [
        self::SUPPLIER => "Поставщик услуг",
        self::CUSTOMER     => "Потребитель"
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="title",type="string",length=100)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="description",type="text",nullable=true)
     */
    protected $description;

    /**
     * @var integer
     * @ORM\Column(name="views_count",type="integer",nullable=true)
     */
    protected $viewsCount;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_changed",type="datetime", nullable=true)
     */
    protected $dateChanged;

    /**
     * @var integer
     * @ORM\Column(name="type",type="integer",nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(name="address",type="string",length=255)
     */
    protected $address;

    /**
     * @var string
     * @ORM\Column(name="avatar",type="string",length=255)
     */
    protected $avatar;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }


    /**
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    /**
     * @param int $viewsCount
     */
    public function setViewsCount(int $viewsCount): void
    {
        $this->viewsCount = $viewsCount;
    }

    /**
     * @return \DateTime
     */
    public function getDateChanged(): \DateTime
    {
        return $this->dateChanged;
    }

    /**
     * @param \DateTime $dateChanged
     */
    public function setDateChanged(\DateTime $dateChanged): void
    {
        $this->dateChanged = $dateChanged;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

}
