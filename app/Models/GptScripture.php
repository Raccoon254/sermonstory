<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GptScripture extends Model
{
    use HasFactory;
    //set table name
    protected $table = 'gptscriptures';

    protected $fillable = [
        'story_id',
        'verse',
        'content',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(GptStory::class);
    }
}

