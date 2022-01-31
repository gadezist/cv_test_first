<?php

namespace App\Controller\Link;

use App\Application\Command\ClickLinkCommand;
use App\Application\Command\ClickLinkCommandHandler;
use App\Application\Command\CreateLinkCommand;
use App\Controller\RequestDTO\ClickLinkDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClickLinkController extends AbstractController
{
    public function __construct(
        private ClickLinkCommandHandler $clickLinkCommandHandler,
    ){}

    #[Route('/{link}', name: 'click_link', methods: ['Get'])]
    public function __invoke(Request $request, string $link)
    {
        $createLinkDTO = $this->prepareClickLinkDTO($request);

        $clickLinkCommand = new ClickLinkCommand(
            $createLinkDTO->ip,
            $createLinkDTO->userAgent,
            $link,
        );

        $redirectUrl = ($this->clickLinkCommandHandler)($clickLinkCommand);

        if ($redirectUrl === false) {
            return new Response('404 Not found', Response::HTTP_NOT_FOUND, ['content-type' => 'text/html']);
        }

        return new RedirectResponse($redirectUrl);
    }

    private function prepareClickLinkDTO(Request $request): ClickLinkDTO
    {
        $createLinkDTO = new ClickLinkDTO();

        $createLinkDTO->ip = $request->getClientIp();
        $createLinkDTO->userAgent = $request->headers->get('User-Agent');

        return $createLinkDTO;
    }
}
