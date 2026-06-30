<?php

namespace App\Services;

use App\DTO\ChapterCreatedEventDTO;
use App\Mappers\ChapterProjectionMapper;
use App\Repositories\ChapterProjectionRepository;
use App\Repositories\ProcessedEventRepository;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;


readonly class CatalogProjectionService
{
    public function __construct(
        private ChapterProjectionRepository $chapterProjectionRepository,
        private ChapterProjectionMapper     $chapterProjectionMapper,
        private ProcessedEventRepository    $eventRepository,
        private TracingService              $tracingService,
    )
    {
    }

    public function handle(ChapterCreatedEventDTO $event): void
    {
        $this->tracingService->trace(
            'catalog_projection.process_created_event',
            function () use ($event): void {
                $chapter = $this->chapterProjectionMapper->toModel($event->chapterCreatedEventDataDTO);
                try {
                    $this->chapterProjectionRepository->create($chapter);
                } catch (UniqueConstraintViolationException $e) {
                    return;
                }
                $this->eventRepository->save($event->metadataDTO->eventUuid, $event->metadataDTO->eventType);
                Log::info("new chapter process completed successfully");
            }, [
                'event.uuid' => $event->metadataDTO->eventUuid,
                'event.type' => $event->metadataDTO->eventType,
                'chapter.uuid' => $event->chapterCreatedEventDataDTO->chapterUuid,
            ]
        );
    }
}
