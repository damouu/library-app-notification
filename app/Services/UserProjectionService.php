<?php

namespace App\Services;

use App\DTO\UserCreatedEventDTO;
use App\Mappers\UserProjectionMapper;
use App\Repositories\ProcessedEventRepository;
use App\Repositories\UserProjectionRepository;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;


readonly class UserProjectionService
{
    public function __construct(
        private UserProjectionRepository $userProjectionRepository,
        private UserProjectionMapper     $userProjectionMapper,
        private ProcessedEventRepository $eventRepository,
        private MailService              $mailService
    )
    {
    }

    public function handle(UserCreatedEventDTO $event): void
    {
        $userProjection = $this->userProjectionMapper->toModel($event->userCreatedEventDataDTO);
        try {
            $this->userProjectionRepository->create($userProjection);
        } catch (UniqueConstraintViolationException $e) {
            return;
        }
        $this->eventRepository->save($event->metadataDTO->eventUuid, $event->metadataDTO->eventType);
        $this->mailService->sendUserRegistered($userProjection);
        Log::info("new user process completed successfully");
    }
}
