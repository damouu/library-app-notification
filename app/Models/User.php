<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use SoftDeletes, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'card_uuid',
    ];

    protected function casts(): array
    {
        return [
            'email' => 'string',
            'card_uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
