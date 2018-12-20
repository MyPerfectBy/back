<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Overblog\GraphQLBundle\ExpressionLanguage\ExpressionFunction\DependencyInjection\Service;

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
     * @var Service
     * @ORM\ManyToOne(targetEntity="App\Entity\Services")
     * @ORM\JoinColumn(name="service", referencedColumnName="id")
     */
    protected $service;


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
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @param Service $service
     */
    public function setService(Service $service): void
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
}
