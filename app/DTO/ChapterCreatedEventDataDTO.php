<?php

namespace App\DTO;

final readonly class ChapterCreatedEventDataDTO
{
    public function __construct(
        public string  $chapterUuid,
        public string  $seriesUuid,
        public string  $title,
        public ?string $secondTitle,
        public int     $chapterNumber,
        public int     $totalPages,
        public string  $summary,
        public string  $coverArtworkUrl,
        public string  $publicationDate,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            chapterUuid: $payload['chapter_uuid'],
            seriesUuid: $payload['series_uuid'],
            title: $payload['title'],
            secondTitle: $payload['second_title'],
            chapterNumber: $payload['chapter_number'],
            totalPages: $payload['total_pages'],
            summary: $payload['summary'],
            coverArtworkUrl: $payload['cover_artwork_url'],
            publicationDate: $payload['publication_date'],
        );
    }
}
