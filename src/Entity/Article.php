<?php

namespace App\Entity;

// use JMS\Serializer\Serializer;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list"})
     * @Serializer\Expose()
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     * @Serializer\Groups({"detail", "list"})
     * @Serializer\Expose()
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     * @Serializer\Groups({"detail", "list"})
     * @Serializer\Expose()
     * 
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
