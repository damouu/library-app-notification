<?php

namespace App\DTO;

final readonly class BorrowCreatedEventDTO
{
    public function __construct(
        public MetadataDTO               $metadataDTO,
        public BorrowCreatedEventDataDTO $borrowCreatedEventDataDTO,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            metadataDTO: MetadataDTO::fromArray($payload['metadata']),
            borrowCreatedEventDataDTO: BorrowCreatedEventDataDTO::fromArray($payload['data']),
        );
    }
}
