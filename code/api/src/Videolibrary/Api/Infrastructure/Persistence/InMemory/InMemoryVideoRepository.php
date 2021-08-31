<?php

namespace Videolibrary\Api\Infrastructure\Persistence\InMemory;

use Videolibrary\Api\Domain\Model\Videos\Status;
use Videolibrary\Api\Domain\Model\Videos\Video;
use Videolibrary\Api\Domain\Model\Videos\VideoCollection;
use Videolibrary\Api\Domain\Model\Videos\VideoDuration;
use Videolibrary\Api\Domain\Model\Videos\VideoId;
use Videolibrary\Api\Domain\Model\Videos\VideoRepository;
use Videolibrary\Api\Domain\Model\Videos\VideoTitle;

class InMemoryVideoRepository implements VideoRepository
{
    private array $videos;

    public function __construct()
    {
        $this->videos[] = new Video(new VideoId('1'), new VideoTitle('Title 1'), new VideoDuration(100), new Status('pending'));
        $this->videos[] = new Video(new VideoId('2'), new VideoTitle('Title 2'), new VideoDuration(200), new Status('published'));
        $this->videos[] = new Video(new VideoId('3'), new VideoTitle('Title 3'), new VideoDuration(300), new Status('pending'));
        $this->videos[] = new Video(new VideoId('4'), new VideoTitle('Title 4'), new VideoDuration(400), new Status('published'));
        $this->videos[] = new Video(new VideoId('5'), new VideoTitle('Title 5'), new VideoDuration(500), new Status('removed'));
    }

    public function findByStatus(Status $status): VideoCollection
    {
        $videoCollection = new VideoCollection();

        array_map(static function ($video) use ($videoCollection, $status){
            if ($video->status()->equals($status)) {
                $videoCollection->add($video);
            }
        }, $this->videos);

        return $videoCollection;
    }

    public function insert(Video $video): void
    {
        // TODO: Implement insert() method.
    }
}
