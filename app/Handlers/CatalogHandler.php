<?php

namespace App\Handlers;

use App\DTO\ChapterCreatedEventDTO;
use App\Repositories\ProcessedEventRepository;
use App\Services\CatalogProjectionService;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

class CatalogHandler
{

    public function __construct(
        private readonly CatalogProjectionService $catalogProjectionService,
        private readonly ProcessedEventRepository $eventRepository,
    ){}

    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $event = ChapterCreatedEventDTO::fromArray((array)$message->getBody());
        if ($this->eventRepository->exists($event->metadataDTO->eventUuid)) {
            return;
        }
        $this->catalogProjectionService->handle($event);
    }
}
