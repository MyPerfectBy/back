<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Table(name="file_photos")
 *@ORM\HasLifecycleCallbacks()
 *@ORM\Entity(repositoryClass="App\Repository\PhotoRepository")

 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var integer
     * @ORM\Column(name="author", type="integer", nullable=true)
     */
    protected $author;

    /**
     * @var String
     * @ORM\Column(name="realFileName", type="string", length=500, nullable=false)
     */
    protected $realFileName;

    /**
     * @var String
     * @ORM\Column(name="uniqFileName", type="string", length=500, nullable=false)
     */
    protected $uniqFileName;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateCreated", type="datetime", nullable=false)
     */
    protected $dateCreated;

    /**
     * @var String
     * @ORM\Column(name="filePath", type="string", length=500, nullable=false)
     */

    protected $filePath ;

    /**
     * @var String
     * @ORM\Column(name="type", type="string", length=500, nullable=false)
     */

    protected $type;

    /**
     * @var String
     * @ORM\Column(name="size", type="string", length=100, nullable=true)
     */
    protected $size;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="FileTokens", mappedBy="file", cascade={"persist", "remove"})
     */
    protected $tokens;

    /**
    *  @ORM\PrePersist()
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
     * @return int|null
     */
    public function getAuthor(): ?int
    {
        return $this->author;
    }

    /**
     * @param int|null $author
     */
    public function setAuthor(?int $author): void
    {
        $this->author = $author;
    }


    /**
     * @return String
     */
    public function getUniqFileName(): String
    {
        return $this->uniqFileName;
    }

    /**
     * @param String $uniqFileName
     */
    public function setUniqFileName(String $uniqFileName): void
    {
        $this->uniqFileName = $uniqFileName;
    }

    /**
     * @return String
     */
    public function getRealFileName(): String
    {
        return $this->realFileName;
    }

    /**
     * @param String $realFileName
     */
    public function setRealFileName(String $realFileName): void
    {
        $this->realFileName = $realFileName;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return String
     */
    public function getFilePath(): String
    {
        return $this->filePath;
    }

    /**
     * @param String $filePath
     */
    public function setFilePath(String $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return String
     */
    public function getType(): String
    {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType(String $type): void
    {
        $this->type = $type;
    }

    /**
     * @return String
     */
    public function getSize(): ?String
    {
        return $this->size;
    }

    /**
     * @param String $size
     */
    public function setSize(?String $size): void
    {
        $this->size = $size;
    }

    /**
     * Get token
     *
     * @return Collection
     */
    public function getTokens()
    {
        return $this->tokens;
    }

}
