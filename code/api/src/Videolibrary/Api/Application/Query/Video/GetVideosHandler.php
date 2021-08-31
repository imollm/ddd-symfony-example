<?php

namespace Videolibrary\Api\Application\Query\Video;

use App\Shared\Domain\StringValueObject;
use Videolibrary\Api\Application\Request\Video\GetVideosRequest;
use Videolibrary\Api\Application\Response\Video\VideoCollectionResponse;
use Videolibrary\Api\Domain\Model\Videos\InvalidStatusValueException;
use Videolibrary\Api\Domain\Model\Videos\VideoRepository;
use Videolibrary\Api\Domain\Model\Videos\Status;

class GetVideosHandler
{
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    /**
     * @throws InvalidStatusValueException
     */
    public function __invoke(GetVideosRequest $getVideosRequest): VideoCollectionResponse
    {
        $videos = $this->videoRepository->findByStatus(
            new Status($getVideosRequest->status())
        );

        return new VideoCollectionResponse($videos);
    }
}
