<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
class Author
{
    #[ORM\Column(nullable: true)]
    #[Assert\Length(max: 255)]
    #[Groups('get')]
    private ?string $name;

    #[ORM\Column(nullable: true)]
    #[Assert\Url]
    #[Assert\Length(max: 255)]
    #[Groups('get')]
    private ?string $uri;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Author
    {
        $this->name = $name;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): Author
    {
        $this->uri = $uri;

        return $this;
    }
}
