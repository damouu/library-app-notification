<?php

namespace App\Repositories;

use App\Models\UserProjection;
use App\Services\TracingService;

class UserProjectionRepository
{
    public function __construct
    (
        private TracingService $tracingService
    )
    {
    }

    public function exist(string $userProjectionUuid): bool
    {
        return UserProjection::where('member_card_uuid', $userProjectionUuid)->exists();
    }

    public function findByMemberCardUuid(string $memberCardUuid): UserProjection
    {
        return $this->tracingService->trace(
            'repository.user_projection.findByMemberCardUuid',
            function () use ($memberCardUuid) {
                return UserProjection::where('member_card_uuid', $memberCardUuid)->firstOrFail();
            }
        );
    }

    public function create(UserProjection $userProjection): UserProjection
    {
        return $this->tracingService->trace(
            'repository.user_projection.save',
            function () use ($userProjection) {
                $userProjection->save();
                return $userProjection;
            }, [
                'db.collection' => 'user_projections',
            ]
        );
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
