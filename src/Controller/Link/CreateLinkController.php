<?php

namespace App\Controller\Link;

use App\Application\Command\CreateLinkCommand;
use App\Application\Command\CreateLinkCommandHandler;
use App\Controller\RequestDTO\CreateLinkDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CreateLinkController extends AbstractController
{
    public function __construct(
        private CreateLinkCommandHandler $createLinkCommandHandler,
        private HttpClientInterface $httpClient,
    ){}

    #[Route('/link', name: 'create_link', methods: ['Post'])]
    public function __invoke(Request $request)
    {
        if (($error = $this->validateRequest($request)) !== true) {
            return new JsonResponse($error, Response::HTTP_BAD_REQUEST);
        }

        $createLinkDTO = $this->prepareCreateLinkDTO($request);

        $createLinkCommand = new CreateLinkCommand(
            $createLinkDTO->longUrl,
            $createLinkDTO->title,
            $createLinkDTO->tags
        );

        $shortUrl = ($this->createLinkCommandHandler)($createLinkCommand, $request->getHost());

        return new JsonResponse(['status' => 'ok', 'short_url' => $shortUrl], Response::HTTP_OK);
    }

    private function prepareCreateLinkDTO(Request $request): CreateLinkDTO
    {
        $createLinkDTO = new CreateLinkDTO();
        if ($request->request->get('long_url') !== null) {
            $createLinkDTO->longUrl = $request->request->get('long_url');
        } else {
            return new JsonResponse(['status' => 'ko', 'error' => 'Parameter "long_url" can be present'], Response::HTTP_BAD_REQUEST);
        }
        $createLinkDTO->title = $request->request->get('title');
        $createLinkDTO->tags = json_decode($request->request->get('tags'));

        return $createLinkDTO;
    }

    private function validateRequest(Request $request)
    {
        $longUrl = $request->request->get('long_url');
        if ($longUrl === null) {
            return ['status' => 'ko', 'error' => 'Parameter "long_url" can be present'];
        }
        try {
            $response = $this->httpClient->request(
                'GET',
                $longUrl,
            );
        } catch (\Exception $e) {
            return ['status' => 'ko', 'error' => 'this url incorrect'];
        }

        if ($response->getStatusCode() !== 200) {
            return ['status' => 'ko', 'error' => 'this url incorrect'];
        }

        return true;
    }
}
