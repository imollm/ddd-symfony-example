<?php

namespace Videolibrary\Api\Infrastructure\Ui\Http\Controller\Videos;

use App\Shared\Domain\StringValueObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Videolibrary\Api\Application\Query\Video\GetVideosHandler;
use Videolibrary\Api\Application\Request\Video\GetVideosRequest;
use Videolibrary\Api\Domain\Model\Videos\InvalidStatusValueException;

class GetVideosController
{
    private GetVideosHandler $getVideosHandler;

    public function __construct(GetVideosHandler $getVideosHandler)
    {
        $this->getVideosHandler = $getVideosHandler;
    }


    public function __invoke(Request $request): JsonResponse
    {
        try {
            $status = $request->get('status') ?? 'pending';

            $videos = ($this->getVideosHandler)(new GetVideosRequest($status));

            $response = new JsonResponse([
                'status' => 'ok',
                'videos' => $videos->toArray()
            ]);

        } catch (InvalidStatusValueException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }

        return $response;
    }
}
