<?php

namespace Videolibrary\Api\Domain\Model\Subtitle;

use App\Shared\Domain\StringValueObject;

class SubtitleLanguage extends StringValueObject
{
    private const LANGUAGES = ['es', 'en', 'fr', 'de', 'pt', 'it',];

    /**
     * @throws InvalidSubtitleLanguageValue
     */
    public function __construct(string $language)
    {
        if (!in_array($language, self::LANGUAGES)) {
            throw new InvalidSubtitleLanguageValue();
        }
        parent::__construct($language);
    }


}
