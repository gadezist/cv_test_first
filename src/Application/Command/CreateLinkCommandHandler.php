<?php

declare(strict_types=1);

namespace App\Application\Command;


use App\Entity\Link;
use App\Repository\LinkRepository;

class CreateLinkCommandHandler
{
    public function __construct(
        private LinkRepository $linkRepository,
    ){}

    public function __invoke(CreateLinkCommand $createLinkCommand, $host): string
    {
        $link = new Link();
        $link->setLongUrl($createLinkCommand->getLongUrl());
        do {
            $shortLink = $this->generateShortLink(str_shuffle($createLinkCommand->getLongUrl()));
            if (!$this->linkRepository->findBy(['short_url' => $shortLink])) {
                break;
            }
        } while(0);

        $link->setShortUrl($shortLink);

        if ($createLinkCommand->getTitle() !== null) {
            $link->setTitle($createLinkCommand->getTitle());
        }
        if ($createLinkCommand->getTags() !== null) {
            $link->setTags($createLinkCommand->getTags());
        }
        $this->linkRepository->add($link);

        return 'https://' . $host . ':8000/' . $shortLink;
    }

    private function generateShortLink($link): string
    {
        $hash = hash('sha256', $link);
        $shortLink = substr($this->base62Encode($hash), 0, 7);

        return $shortLink;
    }

    function base62Encode($data) {
        $outstring = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i += 8) {
            $chunk = substr($data, $i, 8);
            $outlen = ceil((strlen($chunk) * 8)/6); //8bit/char in, 6bits/char out, round up
            $x = bin2hex($chunk);  //gmp won't convert from binary, so go via hex
            $w = gmp_strval(gmp_init(ltrim($x, '0'), 16), 62); //gmp doesn't like leading 0s
            $pad = str_pad($w, (int)$outlen, '0', STR_PAD_LEFT);
            $outstring .= $pad;
        }
        return $outstring;
    }
}
