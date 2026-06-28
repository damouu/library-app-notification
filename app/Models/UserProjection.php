<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserProjection extends Model
{
    use SoftDeletes, HasFactory, Notifiable;

    protected $table = 'user_projection';

    protected $fillable = [
        'email',
        'avatar_img_url',
        'user_name',
        'member_card_uuid'
    ];

    protected function casts(): array
    {
        return [
            'member_card_uuid' => 'string',
            'user_name' => 'string',
            'email' => 'string',
            'avatar_img_url' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
