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
        'series_uuid',
        'title',
        'second_title',
        'total_pages',
        'chapter_number',
        'summary',
        'cover_artwork_url',
        'publication_date',
    ];

    protected function casts(): array
    {
        return [
            'chapter_uuid' => 'string',
            'series_uuid' => 'string',
            'title' => 'string',
            'second_title' => 'string',
            'total_pages' => 'integer',
            'chapter_number' => 'integer',
            'summary' => 'string',
            'cover_artwork_url' => 'string',
            'publication_date' => 'date',
        ];
    }
}
