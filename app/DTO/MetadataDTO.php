<?php

namespace App\DTO;

final readonly class MetadataDTO
{
    public function __construct(
        public string $eventUuid,
        public string $eventType,
        public string $timestamp,
        public string $sourceService,
    ){}

    public static function fromArray(array $eventMetadata): self
    {
        return new self(
            $eventMetadata['event_uuid'],
            $eventMetadata['event_type'],
            $eventMetadata['timestamp'],
            $eventMetadata['source_service'],
        );
    }

}
