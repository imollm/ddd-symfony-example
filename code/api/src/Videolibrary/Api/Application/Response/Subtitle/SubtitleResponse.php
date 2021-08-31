<?php

namespace Videolibrary\Api\Application\Response\Subtitle;

use Videolibrary\Api\Domain\Model\Subtitle\Subtitle;

class SubtitleResponse
{
    private string $id;
    private string $language;

    public function __construct(Subtitle $subtitle)
    {
        $this->id = $subtitle->id()->value();
        $this->language = $subtitle->language()->value();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'language' => $this->language(),
        ];
    }
}
