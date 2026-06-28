<?php

namespace App\Services;

use App\DTO\ReturnCreatedEventDTO;
use App\Repositories\ChapterProjectionRepository;
use App\Repositories\ProcessedEventRepository;
use App\Repositories\UserProjectionRepository;
use Illuminate\Support\Facades\Log;


readonly class ReturnService
{
    public function __construct(
        private UserProjectionRepository    $userProjectionRepository,
        private ChapterProjectionRepository $chapterProjectionRepository,
        private ProcessedEventRepository    $eventRepository,
        private MailService                 $mailService
    )
    {
    }

    public function handle(ReturnCreatedEventDTO $event): void
    {
        $user = $this->userProjectionRepository->findByMemberCardUuid($event->returnCreatedEventDataDTO->memberCardUuid);
        if ($user === null) {
            return;
        }
        $chapterUuids = array_map(
            fn($item) => $item->chapterUuid,
            $event->returnCreatedEventDataDTO->borrowedItems
        );
        $chapters = $this->chapterProjectionRepository->findByChapterUuids($chapterUuids);
        $this->eventRepository->save($event->metadataDTO->eventUuid, $event->metadataDTO->eventType);
        $this->mailService->sendReturn($event, $user, $chapters);
        Log::info('Return event processed successfully');
    }
}
