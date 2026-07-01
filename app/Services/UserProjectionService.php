<?php

namespace App\Services;

use App\DTO\UserCreatedEventDTO;
use App\Mappers\UserProjectionMapper;
use App\Repositories\ChapterProjectionRepository;
use App\Repositories\ProcessedEventRepository;
use App\Repositories\UserProjectionRepository;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Throwable;


readonly class UserProjectionService
{
    public function __construct(
        private UserProjectionRepository    $userProjectionRepository,
        private UserProjectionMapper        $userProjectionMapper,
        private ProcessedEventRepository    $eventRepository,
        private MailService                 $mailService,
        private TracingService              $tracingService,
        private ChapterProjectionRepository $chapterProjectionRepository,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function handle(UserCreatedEventDTO $event): void
    {
        $this->tracingService->trace(
            'user_projection.process_created_event',
            function () use ($event): void {
                $userProjection = $this->userProjectionMapper->toModel($event->userCreatedEventDataDTO);
                try {
                    $this->userProjectionRepository->create($userProjection);
                } catch (UniqueConstraintViolationException $e) {
                    return;
                }
                $this->eventRepository->save($event->metadataDTO->eventUuid, $event->metadataDTO->eventType);
                $popularChapters = $this->chapterProjectionRepository->findPopular();
                $this->mailService->sendUserRegistered($userProjection, $popularChapters);
                Log::info("new user process completed successfully");
            }, [
                'event.uuid' => $event->metadataDTO->eventUuid,
                'event.type' => $event->metadataDTO->eventType,
                'memberCard.uuid' => $event->userCreatedEventDataDTO->memberCardUuid,
            ]
        );
    }
}
