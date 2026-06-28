<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ChapterProjection extends Model
{
    use SoftDeletes, HasFactory, Notifiable;

    protected $table = 'chapter_projection';

    protected $fillable = [
        'chapter_uuid',
        'title',
        'second_title',
        'chapter_number',
        'cover_artwork_url',
    ];

    protected function casts(): array
    {
        return [
            'chapter_uuid' => 'string',
            'title' => 'string',
            'second_title' => 'string',
            'chapter_number' => 'integer',
            'cover_artwork_url' => 'string',
        ];
    }
}
