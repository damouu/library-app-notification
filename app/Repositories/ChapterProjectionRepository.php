<?php

namespace App\Repositories;

use App\Models\ChapterProjection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ChapterProjectionRepository
{

    public function exist(string $chapterUuid): bool
    {
        return ChapterProjection::where('chapter_uuid', $chapterUuid)->exists();
    }


    public function findByChapterUuids(array $uuids): Collection
    {
        return collect($uuids)
            ->map(function ($uuid) {
                $chapter = Cache::remember(
                    "chapter:uuid:$uuid",
                    now()->addHours(6),
                    fn() => $this->fetchChapter($uuid)
                );
                return $chapter;
            })
            ->filter(fn($chapter) => $chapter !== null)
            ->values();
    }

    private function fetchChapter(string $uuid): ?array
    {
        return ChapterProjection::where('chapter_uuid', $uuid)
            ->first()
            ?->toArray();
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
