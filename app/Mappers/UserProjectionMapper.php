<?php

namespace App\Mappers;

use App\DTO\UserCreatedEventDataDTO;
use App\Models\UserProjection;

class UserProjectionMapper
{
    public function toModel(UserCreatedEventDataDTO $event): UserProjection
    {
        return new UserProjection([
            'member_card_uuid' => $event->memberCardUuid,
            'user_name' => $event->userName,
            'email' => $event->email,
            'avatar_img_url' => $event->avatarImgUrl,
        ]);
    }
}
