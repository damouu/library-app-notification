<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class TrendingChapterRepository
{
    private const KEY = 'trending_chapters';

    public function push(Collection $chapters): void
    {
        foreach ($chapters as $chapter) {

            Redis::lrem(self::KEY, 0, json_encode($chapter));

            Redis::lpush(self::KEY, json_encode($chapter));
        }

        Redis::ltrim(self::KEY, 0, 9);

        Redis::expire(self::KEY, 604800);
    }


    public function latest(int $limit = 3): Collection
    {
        return collect(Redis::lrange(self::KEY, 0, $limit - 1))->map(fn($item) => json_decode($item, true));
    }
}
