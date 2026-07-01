<?php

namespace App\Repositories;

use App\Models\ChapterProjection;
use App\Services\TracingService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ChapterProjectionRepository
{

    public function __construct(
        protected ChapterProjection     $chapterProjection,
        private readonly TracingService $tracingService,
    )
    {
    }

    public function exist(string $chapterUuid): bool
    {
        return ChapterProjection::where('chapter_uuid', $chapterUuid)->exists();
    }


    public function findByChapterUuids(array $uuids): Collection
    {
        return $this->tracingService->trace(
            'repository.chapter_projection.findByChapterUuids',
            function () use ($uuids) {
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
        );
    }

    public function findPopular(int $limit = 3): Collection
    {
        return $this->tracingService->trace(
            'repository.chapter_projection.findPopular',
            function () use ($limit) {

                $allKeys = Redis::connection('cache')->keys('laravel-cache-chapter:uuid:*');

                if (empty($allKeys)) {
                    return collect();
                }

                $cleanKeys = array_map(function ($key) {
                    return str_replace('laravel-database-laravel-cache-', '', $key);
                }, $allKeys);

                $slicedKeys = array_slice($cleanKeys, 0, $limit);

                $chapters = Cache::many($slicedKeys);

                return collect($chapters)->filter()->values();
            }
        );
    }

    private function fetchChapter(string $uuid): ?array
    {
        return ChapterProjection::where('chapter_uuid', $uuid)
            ->first()
            ?->toArray();
    }

    public function create(ChapterProjection $chapter): ChapterProjection
    {
        return $this->tracingService->trace(
            'repository.chapter_projection.create',
            function () use ($chapter) {
                $chapter->save();
                return $chapter;
            }, [
                'db.collection' => 'chapter_projections',
            ]
        );
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
