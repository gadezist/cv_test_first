<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
class Link
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $longUrl;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'json', nullable: true)]
    private $tags = [];

    #[ORM\Column(type: 'string', length: 255)]
    private $short_url;

    #[ORM\OneToMany(mappedBy: 'link', targetEntity: ClickLink::class)]
    private $clickLinks;

    public function __construct()
    {
        $this->clickLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    public function setLongUrl(string $longUrl): self
    {
        $this->longUrl = $longUrl;

        return $this;
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

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->short_url;
    }

    public function setShortUrl(string $short_url): self
    {
        $this->short_url = $short_url;

        return $this;
    }

    /**
     * @return Collection|ClickLink[]
     */
    public function getClickLinks(): Collection
    {
        return $this->clickLinks;
    }

    public function addClickLink(ClickLink $clickLink): self
    {
        if (!$this->clickLinks->contains($clickLink)) {
            $this->clickLinks[] = $clickLink;
            $clickLink->setLink($this);
        }

        return $this;
    }

    public function removeClickLink(ClickLink $clickLink): self
    {
        if ($this->clickLinks->removeElement($clickLink)) {
            // set the owning side to null (unless already changed)
            if ($clickLink->getLink() === $this) {
                $clickLink->setLink(null);
            }
        }

        return $this;
    }
}
