<?php

namespace App\DTO;

final readonly class ChapterCreatedEventDataDTO
{
    public function __construct(
        public string  $chapterUuid,
        public string  $title,
        public ?string $secondTitle,
        public int     $chapterNumber,
        public string  $coverArtworkUrl,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            chapterUuid: $payload['chapter_uuid'],
            title: $payload['title'],
            secondTitle: $payload['second_title'],
            chapterNumber: $payload['chapter_number'],
            coverArtworkUrl: $payload['cover_artwork_url']
        );
    }
}
