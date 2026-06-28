<?php

namespace App\DTO;

final readonly class ReturnCreatedEventDTO
{
    public function __construct(
        public MetadataDTO               $metadataDTO,
        public ReturnCreatedEventDataDTO $returnCreatedEventDataDTO,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            metadataDTO: MetadataDTO::fromArray($payload['metadata']),
            returnCreatedEventDataDTO: ReturnCreatedEventDataDTO::fromArray($payload['data']),
        );
    }
}
