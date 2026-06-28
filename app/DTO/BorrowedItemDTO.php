<?php

namespace App\DTO;

final readonly class BorrowedItemDTO
{
    public function __construct(
        public string $chapterUuid,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            chapterUuid: $payload['chapter_uuid'],
        );
    }
}
