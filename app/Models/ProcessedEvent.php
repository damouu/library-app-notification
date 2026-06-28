<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessedEvent extends Model
{
    protected $fillable = [
        'event_uuid',
        'event_type',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'event_uuid' => 'string',
            'event_type' => 'string',
            'processed_at' => 'datetime',
        ];
    }
}
