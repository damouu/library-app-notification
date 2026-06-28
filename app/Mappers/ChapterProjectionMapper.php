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
            'title' => $event->title,
            'second_title' => $event->secondTitle,
            'chapter_number' => $event->chapterNumber,
            'cover_artwork_url' => $event->coverArtworkUrl,
        ]);
    }
}
