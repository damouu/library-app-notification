<?php

namespace App\Repositories;

use App\Models\UserProjection;

class UserProjectionRepository
{
    public function firstOrCreate(array $attributes, array $values = []): UserProjection
    {
        return UserProjection::firstOrCreate($attributes, $values);
    }

    public function exist(string $userProjectionUuid): bool
    {
        return UserProjection::where('member_card_uuid', $userProjectionUuid)->exists();
    }

    public function create(UserProjection $userProjection): UserProjection
    {
        $userProjection->save();
        return $userProjection;
    }

    public function save(UserProjection $UserProjection): UserProjection
    {
        $UserProjection->save();
        return $UserProjection;
    }

    public function delete(UserProjection $UserProjection): bool
    {
        return $UserProjection->delete();
    }
}
