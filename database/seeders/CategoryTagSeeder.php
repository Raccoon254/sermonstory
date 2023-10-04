<?php

namespace Database\Seeders;

use App\Models\CategoryTag;
use Illuminate\Database\Seeder;

class CategoryTagSeeder extends Seeder
{
    public function run()
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
            CategoryTag::create(['name' => $category]);
        }
    }
}

