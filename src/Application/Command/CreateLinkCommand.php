<?php

declare(strict_types=1);

namespace App\Application\Command;


class CreateLinkCommand
{
    public function __construct(
        private string $longUrl,
        private ?string $title,
        private ?array $tags,
    ){}

    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->longUrl;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }
}
