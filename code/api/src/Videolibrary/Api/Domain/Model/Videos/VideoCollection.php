<?php

namespace Videolibrary\Api\Domain\Model\Videos;

use App\Shared\Domain\ObjectCollection;

class VideoCollection extends ObjectCollection
{
    protected function className(): string
    {
        return Video::class;
    }
}
