<?php

namespace Videolibrary\Api\Domain\Model\Subtitle;

use Videolibrary\Api\Domain\Model\Videos\Video;

class Subtitle
{
    private SubtitleId $id;
    private SubtitleLanguage $language;
    private Video $video;

    public function __construct(SubtitleId $id, SubtitleLanguage $language)
    {
        $this->id = $id;
        $this->language = $language;
    }

    public function id(): SubtitleId
    {
        return $this->id;
    }

    public function language(): SubtitleLanguage
    {
        return $this->language;
    }

    public function video(): Video
    {
        return $this->video;
    }


}
