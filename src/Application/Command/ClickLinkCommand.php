<?php

declare(strict_types=1);

namespace App\Application\Command;


class ClickLinkCommand
{
    public function __construct(
        private ?string $ip,
        private ?string $userAgent,
        private string $shortUrl,
    ){}

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }
}
