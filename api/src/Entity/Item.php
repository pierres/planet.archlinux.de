<?php

namespace App\Entity;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Index(columns: ['last_modified'])]
#[ApiResource(
    operations: [
        new Get(
            controller: NotFoundAction::class,
            openapi: false,
            read: false
        ),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['get'], 'skip_null_values' => false]
)]
class Item
{
    #[ApiProperty(identifier: true)]
    public function getId(): string
    {
        return sha1($this->getLink());
    }

    #[ORM\Id]
    #[ORM\Column]
    #[Assert\Url]
    #[Assert\Length(max: 255)]
    #[ApiProperty(identifier: false)]
    private string $link;

    #[ORM\Column]
    #[Assert\Length(min: 1, max: 255)]
    #[Groups('get')]
    private string $title;

    #[ORM\Column(type: 'text')]
    #[Assert\Length(min: 3, max: 10485760)]
    #[Groups('get')]
    private string $description;

    #[ORM\Column(type: 'datetime')]
    #[Groups('get')]
    private \DateTime $lastModified;

    #[ORM\Embedded(class: Author::class)]
    #[Assert\Valid]
    #[Groups('get')]
    private Author $author;

    #[ORM\ManyToOne(targetEntity: Feed::class, cascade: ['all'], inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'feed_url', referencedColumnName: 'url', nullable: false, onDelete: 'CASCADE')]
    #[Assert\Valid]
    private Feed $feed;

    public function __construct(string $link)
    {
        $this->link = $link;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Item
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    public function setLastModified(\DateTime $lastModified): Item
    {
        $this->lastModified = $lastModified;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): Item
    {
        $this->author = $author;
        return $this;
    }

    public function getFeed(): Feed
    {
        return $this->feed;
    }

    public function setFeed(Feed $feed): Item
    {
        $this->feed = $feed;
        return $this;
    }
}
