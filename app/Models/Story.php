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

    public function relatedStories()
{
    // Get the IDs of the categories of the current story
    $categoryIds = $this->categoryTags->pluck('id');

    // Get all stories that belong to these categories
    return Story::whereHas('categoryTags', function ($query) use ($categoryIds) {
        $query->whereIn('id', $categoryIds);
    })
    // Exclude the current story
    ->where('id', '!=', $this->id)
    // Limit to 4 stories
    ->take(4)
    ->get();
}

}
