<?php

namespace Database\Seeders;

use App\Models\CategoryTag;
use App\Models\GptCategory;
use Illuminate\Database\Seeder;

class GptCategoryTagSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Love',
            'Kindness',
            'Forgiveness',
            'Gentleness',
            'Purity',
            'Honesty',
            'Respect',
            'Responsibility',
            'Empathy',
            'Gratitude',
            'Humility',
            'Courage',
            'Justice',
            'Compassion',
            'Generosity',
            'Self-discipline',
            'Tolerance',
            'Loyalty',
            'Graciousness',
            'Integrity',
            'Patience',
            'Accountability',
            'Cooperation',
            'Empowerment',
            'Adaptability',
            'Sacrifice',
            'Reliability',
            'Contentment',
            'Moderation',
            'Optimism',
            'Tact',
            'Self-respect',
            'Civility',
            'Environmental Responsibility',
            'Nonviolence',
            'Self-awareness',
            'Open-mindedness',
            'Community Engagement'
        ];

        foreach ($categories as $category) {
            GptCategory::create(['name' => $category]);
        }
    }
}

