<?php

namespace App\Mappers;

use App\DTO\ChapterCreatedEventDataDTO;
use App\Models\ChapterProjection;

class ChapterProjectionMapper
{
    public function toModel(ChapterCreatedEventDataDTO $event): ChapterProjection
    {
        return new ChapterProjection([
            'chapter_uuid' => $event->chapterUuid,
            'series_uuid' => $event->seriesUuid,
            'title' => $event->title,
            'second_title' => $event->secondTitle,
            'total_pages' => $event->totalPages,
            'chapter_number' => $event->chapterNumber,
            'summary' => $event->summary,
            'cover_artwork_url' => $event->coverArtworkUrl,
            'publication_date' => $event->publicationDate,
        ]);
    }
}
