<?php

namespace App\Handlers;

use App\DTO\UserCreatedEventDTO;
use App\Repositories\ProcessedEventRepository;
use App\Services\UserProjectionService;
use Exception;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

class UserHandler
{

    public function __construct(
        private readonly UserProjectionService    $userProjectionService,
        private readonly ProcessedEventRepository $eventRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $event = UserCreatedEventDTO::fromArray((array)$message->getBody());
        if ($this->eventRepository->exists($event->metadataDTO->eventUuid)) {
            return;
        }
        $this->userProjectionService->handle($event);
    }
}
