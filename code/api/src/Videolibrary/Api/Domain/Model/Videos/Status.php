<?php

namespace Videolibrary\Api\Domain\Model\Videos;

use App\Shared\Domain\StringValueObject;

class Status
{
    private StringValueObject $status;

    private const ALLOWED_STATUS = [
        'pending',
        'published',
        'removed'
    ];

    /**
     * @throws InvalidStatusValueException
     */
    public function __construct(string $status)
    {
        if (!in_array($status, self::ALLOWED_STATUS, true)) {
            throw new InvalidStatusValueException();
        }
        $this->status = new StringValueObject($status);
    }

    public function value(): string
    {
        return $this->status->value();
    }

    public function equals(Status $status): bool
    {
        return $this->value() === $status->value();
    }
}
