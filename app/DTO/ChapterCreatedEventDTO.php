<?php

namespace App\DTO;

final readonly class ChapterCreatedEventDTO
{
    public function __construct(
        public MetadataDTO $metadataDTO,
        public ChapterCreatedEventDataDTO $chapterCreatedEventDataDTO,
    ){}

    public static function fromArray(array $payload): self{
        return new self(
            metadataDTO: MetadataDTO::fromArray($payload['metadata']),
            chapterCreatedEventDataDTO: ChapterCreatedEventDataDTO::fromArray($payload['data']),
        );
    }
}
