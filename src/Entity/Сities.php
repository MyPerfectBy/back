<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Table(name="cities")
 *@ORM\HasLifecycleCallbacks()
 *@ORM\Entity(repositoryClass="App\Repository\CitiesRepository")

 */
class Сities
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var String
     * @ORM\Column(name="city", type="string", length=500, nullable=false)
     */
    protected $city;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getCity(): String
    {
        return $this->city;
    }

    /**
     * @param String $city
     */
    public function setCity(String $city): void
    {
        $this->city = $city;
    }


}