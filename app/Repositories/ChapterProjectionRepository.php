<?php

namespace App\Repositories;

use App\Models\ChapterProjection;

class ChapterProjectionRepository
{
    public function firstOrCreate(array $attributes, array $values = []): ChapterProjection
    {
        return ChapterProjection::firstOrCreate($attributes, $values);
    }

    public function findByChapterUuid(string $chapterUuid): ?ChapterProjection
    {
        return ChapterProjection::where('chapter_uuid', $chapterUuid)->findOrFail();
    }

    public function exist(string $chapterUuid): bool
    {
        return ChapterProjection::where('chapter_uuid', $chapterUuid)->exists();
    }

    public function create(ChapterProjection $chapter): ChapterProjection
    {
        $chapter->save();
        return $chapter;
    }

    public function save(ChapterProjection $chapterProjection): ChapterProjection
    {
        $chapterProjection->save();
        return $chapterProjection;
    }

    public function delete(ChapterProjection $chapterProjection): bool
    {
        return $chapterProjection->delete();
    }
}
