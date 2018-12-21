<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileServicesRepository")
 */
class ProfileServices
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Profile
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="services")
     * @ORM\JoinColumn(name="profile", referencedColumnName="id")
     */
    protected $profile;

    /**
     * @var Services
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Services")
     * @ORM\JoinColumn(name="service", referencedColumnName="id")
     */
    protected $service;

    /**
     *@ORM\Column(name="active", type="boolean")
     */
    protected $active;


    /**
     * @var float
     * @ORM\Column(name="price",type="float",nullable=true)
     */
    protected $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Services
     */
    public function getService(): Services
    {
        return $this->service;
    }

    /**
     * @param Services $service
     */
    public function setService(Services $service): void
    {
        $this->service = $service;
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

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }


}
