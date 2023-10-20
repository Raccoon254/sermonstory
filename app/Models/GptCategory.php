<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GptCategory extends Model
{
    use HasFactory;
    protected $table = 'gptcategories';

    protected $fillable = [
        'name',
    ];

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(GptStory::class, 'category_tag_story', 'category_tag_id', 'story_id');
    }

}
