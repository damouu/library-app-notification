<?php

namespace App\Repositories;

use App\Models\ProcessedEvent;

class ProcessedEventRepository
{
    public function exists(string $eventUuid): bool
    {
        return ProcessedEvent::where('event_uuid', $eventUuid)->exists();
    }

    public function save(string $eventUuid, string $eventType): void
    {
        ProcessedEvent::create([
            'event_uuid' => $eventUuid,
            'event_type' => $eventType,
            'processed_at' => now(),
        ]);
    }
}
