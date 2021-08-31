<?php

namespace Videolibrary\Api\Domain\Model\Videos;

use Videolibrary\Api\Domain\Model\Subtitle\SubtitleCollection;

class Video
{
    private VideoId $id;
    private VideoTitle $title;
    private VideoDuration $duration;
    private Status $status;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;
    private SubtitleCollection $subtitles;

    public function __construct(VideoId $id, VideoTitle $title, VideoDuration $duration, Status $status, SubtitleCollection $subtitles)
    {
        $this->id = $id;
        $this->title = $title;
        $this->duration = $duration;
        $this->status = $status;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
        $this->subtitles = $subtitles;
    }

    public function id(): VideoId
    {
        return $this->id;
    }

    public function title(): VideoTitle
    {
        return $this->title;
    }

    public function duration(): VideoDuration
    {
        return $this->duration;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function subtitles(): SubtitleCollection
    {
        return $this->subtitles;
    }


}
