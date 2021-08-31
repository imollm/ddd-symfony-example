<?php

namespace Videolibrary\Api\Application\Command\Video;

use App\Shared\Exceptions\InvalidCollectionObjectException;
use Videolibrary\Api\Application\Request\Video\PostVideoRequest;
use Videolibrary\Api\Application\Response\Video\VideoResponse;
use Videolibrary\Api\Domain\Model\Subtitle\InvalidSubtitleLanguageValue;
use Videolibrary\Api\Domain\Model\Subtitle\Subtitle;
use Videolibrary\Api\Domain\Model\Subtitle\SubtitleCollection;
use Videolibrary\Api\Domain\Model\Subtitle\SubtitleId;
use Videolibrary\Api\Domain\Model\Subtitle\SubtitleLanguage;
use Videolibrary\Api\Domain\Model\Videos\InvalidStatusValueException;
use Videolibrary\Api\Domain\Model\Videos\Status;
use Videolibrary\Api\Domain\Model\Videos\Video;
use Videolibrary\Api\Domain\Model\Videos\VideoDuration;
use Videolibrary\Api\Domain\Model\Videos\VideoId;
use Videolibrary\Api\Domain\Model\Videos\VideoRepository;
use Videolibrary\Api\Domain\Model\Videos\VideoTitle;
use Videolibrary\Api\Domain\Service\IdStringGenerator;

class PostVideoHandler
{
    private VideoRepository $videoRepository;
    private IdStringGenerator $idStringGenerator;

    public function __construct(VideoRepository $videoRepository, IdStringGenerator $idStringGenerator)
    {
        $this->videoRepository = $videoRepository;
        $this->idStringGenerator = $idStringGenerator;
    }

    /**
     * @throws InvalidStatusValueException|InvalidSubtitleLanguageValue
     */
    public function __invoke(PostVideoRequest $postVideoRequest): VideoResponse
    {
        $video = new Video(
            new VideoId($this->idStringGenerator->generate()),
            new VideoTitle($postVideoRequest->title()),
            new VideoDuration($postVideoRequest->duration()),
            new Status($postVideoRequest->status()),
            $this->buildSubtitleCollection($postVideoRequest->subtitles())
        );

        $this->videoRepository->insert($video);

        return new VideoResponse($video);
    }

    /**
     * @throws InvalidSubtitleLanguageValue
     */
    private function buildSubtitleCollection(array $subtitles): SubtitleCollection
    {
        $subtitleCollection = new SubtitleCollection();

        if (!empty($subtitles)) {
            foreach ($subtitles as $subtitle) {
                $subtitleCollection->add(new Subtitle(
                    new SubtitleId($this->idStringGenerator->generate()),
                    new SubtitleLanguage($subtitle),
                ));
            }
        }
        return $subtitleCollection;
    }
}
