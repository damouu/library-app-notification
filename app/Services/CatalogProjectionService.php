<?php

namespace App\Services;

use App\DTO\ChapterCreatedEventDTO;
use App\Mappers\ChapterProjectionMapper;
use App\Repositories\ChapterProjectionRepository;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;


readonly class CatalogProjectionService
{
    public function __construct(
        private ChapterProjectionRepository $chapterProjectionRepository,
        private ChapterProjectionMapper     $chapterProjectionMapper
    )
    {
    }

    public function handle(ChapterCreatedEventDTO $event): void
    {
        $chapter = $this->chapterProjectionMapper->toModel($event);
        try {
            $this->chapterProjectionRepository->create($chapter);
        } catch (UniqueConstraintViolationException $e) {
            return;
        }
        Log::info("new chapter process completed successfully");
    }
}
