<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scripture extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'content',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

}
