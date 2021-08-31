<?php

namespace Videolibrary\Api\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Videolibrary\Api\Domain\Model\Subtitle\Subtitle;
use Videolibrary\Api\Domain\Model\Subtitle\SubtitleCollection;
use Videolibrary\Api\Domain\Model\Videos\InvalidStatusValueException;
use Videolibrary\Api\Domain\Model\Videos\Status;
use Videolibrary\Api\Domain\Model\Videos\Video;
use Videolibrary\Api\Domain\Model\Videos\VideoCollection;
use Videolibrary\Api\Domain\Model\Videos\VideoDuration;
use Videolibrary\Api\Domain\Model\Videos\VideoId;
use Videolibrary\Api\Domain\Model\Videos\VideoRepository;
use Videolibrary\Api\Domain\Model\Videos\VideoTitle;
use Videolibrary\Api\Infrastructure\Persistence\Doctrine\Entity\Subtitle as SubtitleEntity;
use Videolibrary\Api\Infrastructure\Persistence\Doctrine\Entity\Video as VideoEntity;

class DoctrineVideoRepository extends DoctrineRepository implements VideoRepository
{
    protected function entityClassName(): string
    {
        return VideoEntity::class;
    }

    /**
     * @throws InvalidStatusValueException
     */
    public function findByStatus(Status $status): VideoCollection
    {
        $videos = $this->repository->findBy([
            'status' => $status->value()
        ]);

        $videoCollection = new VideoCollection();

        if (!empty($videos)) {
            foreach ($videos as $video) {
                $videoCollection->add($this->toDomain($video));
            }
        }

        return $videoCollection;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function insert(Video $video): void
    {
        $this->entityManager->persist($this->toInfrastructure($video));
        $this->entityManager->flush();
    }

    private function toInfrastructure(Video $video): VideoEntity
    {
        $videoEntity = new VideoEntity(
            $video->id()->value(),
            $video->title()->value(),
            $video->duration()->value(),
            $video->status()->value(),
            new ArrayCollection(),
            $video->createdAt(),
            $video->updatedAt(),
        );

        foreach ($video->subtitles()->getCollection() as $subtitle) {
            $videoEntity->addSubtitle($this->subtitleToInfrastructure($subtitle));
        }

        return $videoEntity;
    }

    private function subtitleToInfrastructure(Subtitle $subtitle): SubtitleEntity
    {
        return new SubtitleEntity(
            $subtitle->id()->value(),
            $subtitle->language()->value()
        );
    }

    /**
     * @throws InvalidStatusValueException
     */
    private function toDomain(VideoEntity $video): Video
    {
        return new Video(
            new VideoId($video->id()),
            new VideoTitle($video->title()),
            new VideoDuration($video->duration()),
            new Status($video->status()),
            new SubtitleCollection()
        );
    }
}
