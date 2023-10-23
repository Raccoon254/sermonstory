<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GptStory extends Model
{
    use HasFactory;

    //set table name
    protected $table = 'gptstories';

    protected $fillable = [
        'title',
        'content',
        'moral_lesson',
    ];

    public function scriptures(): HasMany
    {
        return $this->hasMany(GptScripture::class, 'story_id');
    }

    public function generatedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'gptstory_user', 'gptstory_id', 'user_id');
    }
    public function categoryTags(): BelongsToMany
    {
        return $this->belongsToMany(GptCategory::class, 'category_tag_story', 'story_id', 'category_tag_id');
    }

}

