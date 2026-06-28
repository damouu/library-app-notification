<?php

namespace App\Handlers;

use App\DTO\BorrowCreatedEventDTO;
use App\Repositories\ProcessedEventRepository;
use App\Services\BorrowService;
use Exception;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

class BookBorrowedHandler
{

    public function __construct(
        private readonly BorrowService            $borrowService,
        private readonly ProcessedEventRepository $eventRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $event = BorrowCreatedEventDTO::fromArray((array)$message->getBody());
        if ($this->eventRepository->exists($event->metadataDTO->eventUuid)) {
            return;
        }
        $this->borrowService->handle($event);
    }
}
