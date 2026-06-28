<?php

namespace App\Handlers;

use App\DTO\ReturnCreatedEventDTO;
use App\Repositories\ProcessedEventRepository;
use App\Services\ReturnService;
use Exception;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

class BookReturnedHandler
{

    public function __construct(
        private readonly ReturnService            $returnService,
        private readonly ProcessedEventRepository $eventRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $event = ReturnCreatedEventDTO::fromArray((array)$message->getBody());
        if ($this->eventRepository->exists($event->metadataDTO->eventUuid)) {
            return;
        }
        $this->returnService->handle($event);
    }
}
