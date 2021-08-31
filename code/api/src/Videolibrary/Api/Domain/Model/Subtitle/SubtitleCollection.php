<?php

namespace Videolibrary\Api\Domain\Model\Subtitle;

use App\Shared\Domain\ObjectCollection;

class SubtitleCollection extends ObjectCollection
{
    protected function className(): string
    {
        return Subtitle::class;
    }
}
