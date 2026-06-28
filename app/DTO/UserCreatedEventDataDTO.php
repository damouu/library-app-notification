<?php

namespace App\DTO;

final readonly class UserCreatedEventDataDTO
{
    public function __construct(
        public string $memberCardUuid,
        public string $userName,
        public string $email,
        public string $avatarImgUrl
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            memberCardUuid: $payload['member_card_uuid'],
            userName: $payload['user_name'],
            email: $payload['email'],
            avatarImgUrl: $payload['avatar_img_url'],
        );
    }
}
