<?php

namespace App\Entity;

use App\Repository\ClickLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClickLinkRepository::class)]
class ClickLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ip;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $userAgent;

    #[ORM\Column(type: 'datetime_immutable')]
    private $clickAt;

    #[ORM\ManyToOne(targetEntity: Link::class, inversedBy: 'clickLinks')]
    #[ORM\JoinColumn(nullable: false)]
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getClickAt(): ?\DateTimeImmutable
    {
        return $this->clickAt;
    }

    public function setClickAt(\DateTimeImmutable $clickAt): self
    {
        $this->clickAt = $clickAt;

        return $this;
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function setLink(?Link $link): self
    {
        $this->link = $link;

        return $this;
    }
}
