<?php

declare(strict_types=1);

namespace App\Application\Command;


use App\Entity\ClickLink;
use App\Repository\ClickLinkRepository;
use App\Repository\LinkRepository;

class ClickLinkCommandHandler
{
    public function __construct(
        private ClickLinkRepository $clickLinkRepository,
        private LinkRepository $linkRepository,
    ){}

    public function __invoke(ClickLinkCommand $clickLinkCommand)
    {
        $link = $this->linkRepository->findOneBy(['short_url' => $clickLinkCommand->getShortUrl()]);
        if (!$link) {
            return false;
        }
        $clickLink = new ClickLink();
        $clickLink->setIp($clickLinkCommand->getIp());
        $clickLink->setUserAgent($clickLinkCommand->getUserAgent());
        $clickLink->setLink($link);
        $clickLink->setClickAt(new \DateTimeImmutable());

        $this->clickLinkRepository->add($clickLink);

        return $link->getLongUrl();
    }
}
