<?php

namespace Videolibrary\Api\Infrastructure\Ui\Http\Controller\Videos;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Videolibrary\Api\Application\Command\Video\PostVideoHandler;
use Videolibrary\Api\Application\Request\Video\PostVideoRequest;
use Videolibrary\Api\Domain\Model\Subtitle\InvalidSubtitleLanguageValue;
use Videolibrary\Api\Domain\Model\Videos\InvalidStatusValueException;

class PostVideoController
{
    private PostVideoHandler $postVideoHandler;

    public function __construct(PostVideoHandler $postVideoHandler)
    {
        $this->postVideoHandler = $postVideoHandler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {

            $video = ($this->postVideoHandler)(new PostVideoRequest(
                $request->get('title'),
                $request->get('duration'),
                $request->get('status'),
                $request->get('subtitles')
            ));

            return new JsonResponse([
                'status' => 'ok',
                'video' => [
                    $video->toArray()
                ],
            ], 201);

        } catch (InvalidStatusValueException $e) {
            return new JsonResponse([
                'status' => 'status error',
                'message' => 'Invalid status value, ' . $request->get('status')
            ], 400);
        } catch (InvalidSubtitleLanguageValue $e) {
            return new JsonResponse([
                'status' => 'status error',
                'message' => 'Invalid language value, ' . $request->get('subtitles')
            ], 400);
        }
    }
}
