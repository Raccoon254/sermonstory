<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'moral_lesson',
        'conclusion',
    ];

    public function scriptures(): HasMany
    {
        return $this->hasMany(Scripture::class);
    }

    public function categoryTags(): BelongsToMany
    {
        return $this->belongsToMany(CategoryTag::class);
    }

}
