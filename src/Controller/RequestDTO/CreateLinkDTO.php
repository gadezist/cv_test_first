<?php


namespace App\Controller\RequestDTO;


class CreateLinkDTO
{
    public string $longUrl;
    public ?string $title;
    public ?array $tags;
}
