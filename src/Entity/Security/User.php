<?php

namespace App\Entity\Security;

use App\Entity\Profile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Security\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vkontakteId;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @var string The hashed register code
     * @ORM\Column(type="string", nullable=true)
     */
    private $registerCode;

    /**
     * @ORM\Column(name="register_date", type="datetime", nullable=true)
     */
    protected $registerDate;

//    /**
//     * @var Profile|null
//     * @ORM\OneToOne(targetEntity="App\Entity\Profile", mappedBy="user")
//     */
//    protected $profile;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return integer
     */
    public function getVkontakteId()
    {
        return $this->vkontakteId;
    }

    /**
     * @param integer $vkontakteId
     */
    public function setVkontakteId($vkontakteId): void
    {
        $this->vkontakteId = $vkontakteId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getRegisterCode(): string
    {
        return $this->registerCode;
    }

    /**
     * @param string $registerCode
     */
    public function setRegisterCode(string $registerCode): void
    {
        $this->registerCode = $registerCode;
    }

    /**
     * @return mixed
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * @param mixed $registerDate
     */
    public function setRegisterDate($registerDate): void
    {
        $this->registerDate = $registerDate;
    }

//    /**
//     * @return Profile|null
//     */
//    public function getProfile(): ?Profile
//    {
//        return $this->profile;
//    }
//
//    /**
//     * @param Profile|null $profile
//     */
//    public function setProfile(?Profile $profile): void
//    {
//        $this->profile = $profile;
//    }


}
