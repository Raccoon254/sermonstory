<?php

namespace Database\Seeders;

use App\Models\CategoryTag;
use App\Models\Scripture;
use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    public function run()
    {
        // Sample Stories
        $sampleStories = [
            [
                'title' => 'The Kind Samaritan',
                'content' => 'In a town called Jericho, a man was robbed and left for dead. A priest and a Levite passed by, ignoring the man. However, a Samaritan stopped, tended to the man\'s wounds, and took him to an inn for care.',
                'moral_lesson' => 'Show kindness to others regardless of their race or background.',
                'scriptures' => [
                    'Luke 10:25-37'
                ],
                'tags' => ['Love', 'Kindness', 'Compassion']
            ],
            [
                'title' => 'The Lost Son',
                'content' => 'A young man asked for his inheritance early, squandered it, and became destitute. He returned home, expecting rejection. Instead, his father welcomed him with open arms.',
                'moral_lesson' => 'God\'s love and forgiveness are boundless, welcoming all who seek redemption.',
                'scriptures' => [
                    'Luke 15:11-32'
                ],
                'tags' => ['Forgiveness', 'Love', 'Gratitude']
            ],
            [
                'title' => 'David and Goliath',
                'content' => 'David, a young shepherd boy, bravely confronted the Philistine giant, Goliath. With just a sling and stone, he defeated the menacing warrior, proving that faith in God can conquer overwhelming challenges.',
                'moral_lesson' => 'Trust in God and not just our own strengths.',
                'scriptures' => [
                    '1 Samuel 17:1-58'
                ],
                'tags' => ['Courage', 'Faith', 'Empowerment']
            ],
            [
                'title' => 'Noah and The Ark',
                'content' => 'God instructed Noah to build an ark and gather animals before the coming flood. Noah obeyed, and his family was saved from the deluge that covered the Earth.',
                'moral_lesson' => 'Obedience to God, even in the face of ridicule, leads to salvation.',
                'scriptures' => [
                    'Genesis 6:5-9:17'
                ],
                'tags' => ['Obedience', 'Faith', 'Loyalty']
            ],
            [
                'title' => 'The Prodigal Prophet - Jonah',
                'content' => 'Jonah was tasked to go to Nineveh but fled. Swallowed by a giant fish, he repented and was spat out. He then delivered God’s message to Nineveh, and the city repented.',
                'moral_lesson' => 'You cannot run from God’s purpose; repentance leads to mercy.',
                'scriptures' => [
                    'Book of Jonah'
                ],
                'tags' => ['Repentance', 'Mercy', 'Responsibility']
            ],
            [
                'title' => 'Daniel in the Lions’ Den',
                'content' => 'For praying to God, Daniel was thrown into a den of lions. However, his unwavering faith protected him, and he emerged unharmed.',
                'moral_lesson' => 'Staying true to your faith even when faced with death.',
                'scriptures' => [
                    'Daniel 6:1-28'
                ],
                'tags' => ['Faith', 'Courage', 'Loyalty']
            ],
            [
                'title' => 'Esther Saves Her People',
                'content' => 'Esther, a Jewish queen, risked her life to expose a plot to exterminate her people. Her courage saved the Jewish community in Persia.',
                'moral_lesson' => 'Stand up for what is right, regardless of the risks.',
                'scriptures' => [
                    'Book of Esther'
                ],
                'tags' => ['Courage', 'Justice', 'Loyalty']
            ],
            [
                'title' => 'The Tower of Babel',
                'content' => 'People attempted to build a tower to reach heaven. In response, God confused their languages, causing them to scatter and cease their project.',
                'moral_lesson' => 'Pride and trying to be equal with God leads to downfall.',
                'scriptures' => [
                    'Genesis 11:1-9'
                ],
                'tags' => ['Pride', 'Humility', 'Cooperation']
            ],
            [
                'title' => 'Joseph and His Coat of Many Colors',
                'content' => 'Joseph was sold into slavery by his jealous brothers. Despite hardships, he rose to prominence in Egypt and later saved his family during a famine.',
                'moral_lesson' => 'God’s plan is always perfect, even if we don’t understand it.',
                'scriptures' => [
                    'Genesis 37:1-36', 'Genesis 39:1-45:28'
                ],
                'tags' => ['Forgiveness', 'Faith', 'Providence']
            ],
            [
                'title' => 'Ruth and Naomi',
                'content' => 'Ruth, despite being a Moabitess, displayed loyalty to her mother-in-law Naomi. She later became the great-grandmother of King David.',
                'moral_lesson' => 'Loyalty and kindness are rewarded by God.',
                'scriptures' => [
                    'Book of Ruth'
                ],
                'tags' => ['Loyalty', 'Love', 'Kindness']
            ],
            [
                'title' => 'Moses Parts the Red Sea',
                'content' => 'Moses, by God’s power, parted the Red Sea to allow the Israelites to escape Pharaoh’s army. Once they crossed, the waters returned, swallowing the pursuers.',
                'moral_lesson' => 'Trust in God’s deliverance in impossible situations.',
                'scriptures' => [
                    'Exodus 14:1-31'
                ],
                'tags' => ['Faith', 'Trust', 'Empowerment']
            ],
            [
                'title' => 'Paul’s Conversion',
                'content' => 'Paul, once a persecutor of Christians, encountered Christ on the road to Damascus. This experience transformed him into one of Christianity’s most influential apostles.',
                'moral_lesson' => 'God’s transformative power can change even the hardest of hearts.',
                'scriptures' => [
                    'Acts 9:1-31'
                ],
                'tags' => ['Transformation', 'Repentance', 'Faith']
            ]

        ];

        foreach ($sampleStories as $sample) {
            // Create the story
            $story = Story::create([
                'title' => $sample['title'],
                'content' => $sample['content'],
                'moral_lesson' => $sample['moral_lesson']
            ]);

            // Attach scriptures to the story
            foreach ($sample['scriptures'] as $verse) {
                Scripture::create([
                    'story_id' => $story->id,
                    'content' => $verse
                ]);
            }

            // Attach tags (categories) to the story
            foreach ($sample['tags'] as $tagName) {
                $tag = CategoryTag::firstWhere('name', $tagName);
                if ($tag) {
                    $story->categoryTags()->attach($tag->id);
                }
            }
        }
    }
}

