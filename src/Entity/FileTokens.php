<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Table(name="file_token")
 *@ORM\Entity(repositoryClass="App\Repository\FileTokensRepository")
 *@ORM\HasLifecycleCallbacks()
 */
class FileTokens
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Photo", inversedBy="tokens")
     * @ORM\JoinColumn(name="file", referencedColumnName="id")
     */
    protected $file;

    /**
     * @ORM\Column(name="token", type="string", length=250, nullable=false)
     */
    protected $token;

    /**
     * @ORM\Column(name="dateCreated", type="datetime", nullable=false)
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="type", type="string", length=2, nullable=false)
     */
    protected $type;


    /**
     *  @ORM\PrePersist
     */
    public function setCreateDate()
    {
        $this->dateCreated = new \DateTime();

    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return FileTokens
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FileTokens
     */
    public function setDate($date)
    {
        $this->dateCreated = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->dateCreated;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return FileTokens
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set file
     *
     * @param Files $file
     *
     * @return FileTokens
     */
    public function setFile(Files $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return Files
     */
    public function getFile()
    {
        return $this->file;
    }
}
