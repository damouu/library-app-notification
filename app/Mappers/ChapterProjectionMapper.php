<?php

namespace App\Mappers;

use App\DTO\ChapterCreatedEventDTO;
use App\Models\ChapterProjection;

class ChapterProjectionMapper
{
    public function toModel(ChapterCreatedEventDTO $event): ChapterProjection
    {
        return new ChapterProjection([
            'chapter_uuid'       => $event->chapterCreatedEventDataDTO->chapterUuid,
            'series_uuid'        => $event->chapterCreatedEventDataDTO->seriesUuid,
            'title'              => $event->chapterCreatedEventDataDTO->title,
            'second_title'       => $event->chapterCreatedEventDataDTO->secondTitle,
            'total_pages'        => $event->chapterCreatedEventDataDTO->totalPages,
            'chapter_number'     => $event->chapterCreatedEventDataDTO->chapterNumber,
            'summary'            => $event->chapterCreatedEventDataDTO->summary,
            'cover_artwork_url'  => $event->chapterCreatedEventDataDTO->coverArtworkUrl,
            'publication_date'   => $event->chapterCreatedEventDataDTO->publicationDate,
        ]);
    }
}
