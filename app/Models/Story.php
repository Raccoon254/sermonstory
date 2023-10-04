<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'moral_lesson',
    ];

    public function scriptures()
    {
        return $this->hasMany(Scripture::class);
    }

    public function categoryTags()
    {
        return $this->belongsToMany(CategoryTag::class);
    }

}
