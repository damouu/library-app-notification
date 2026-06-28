<?php

namespace App\DTO;

final readonly class UserCreatedEventDTO
{
    public function __construct(
        public MetadataDTO $metadataDTO,
        public UserCreatedEventDataDTO $userCreatedEventDataDTO,
    ){}

    public static function fromArray(array $payload): self{
        return new self(
            metadataDTO: MetadataDTO::fromArray($payload['metadata']),
            userCreatedEventDataDTO: UserCreatedEventDataDTO::fromArray($payload['data']),
        );
    }
}
