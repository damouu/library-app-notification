<?php

namespace App\Services;

use App\DTO\BorrowCreatedEventDTO;
use App\Repositories\ChapterProjectionRepository;
use App\Repositories\ProcessedEventRepository;
use App\Repositories\UserProjectionRepository;
use Illuminate\Support\Facades\Log;


readonly class BorrowService
{
    public function __construct(
        private UserProjectionRepository    $userProjectionRepository,
        private ChapterProjectionRepository $chapterProjectionRepository,
        private ProcessedEventRepository    $eventRepository,
        private MailService                 $mailService
    )
    {
    }

    public function handle(BorrowCreatedEventDTO $event): void
    {
        $user = $this->userProjectionRepository->findByMemberCardUuid($event->borrowCreatedEventDataDTO->memberCardUuid);
        if ($user === null) {
            return;
        }
        $chapterUuids = array_map(
            fn($item) => $item->chapterUuid,
            $event->borrowCreatedEventDataDTO->borrowedItems
        );
        $chapters = $this->chapterProjectionRepository->findByChapterUuids($chapterUuids);
        $this->eventRepository->save($event->metadataDTO->eventUuid, $event->metadataDTO->eventType);
        $this->mailService->sendBorrow($event, $user, $chapters);
        Log::info('Borrow event processed successfully');
    }
}
