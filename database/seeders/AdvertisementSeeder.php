<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            // Sidebar Ads (Multiple for Auto-Rotating Slider)
            [
                'title' => 'Tech Masterclass 2026 - Register Now for 50% Off!',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'sidebar',
                'status' => true,
                'clicks' => 45,
            ],
            [
                'title' => 'Comilla University Special Admissions 2026 - Apply Online',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'sidebar',
                'status' => true,
                'clicks' => 31,
            ],
            [
                'title' => 'CoU Campus IT Fest & Innovation Expo 2026',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'sidebar',
                'status' => true,
                'clicks' => 19,
            ],

            // In-Article Ads (Multiple for Auto-Rotating Slider)
            [
                'title' => 'CoUJA Annual Journalism Conference & Award 2026',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'in_article',
                'status' => true,
                'clicks' => 28,
            ],
            [
                'title' => 'Invest in Independent Journalism - Support CoUJA News',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'in_article',
                'status' => true,
                'clicks' => 14,
            ],

            // Footer Ads (Multiple for Auto-Rotating Slider)
            [
                'title' => 'National IT Olympiad 2026 - CoU Campus Campaign',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'footer',
                'status' => true,
                'clicks' => 9,
            ],
            [
                'title' => 'Official CoUJA Media Partnership Program 2026',
                'type' => 'image',
                'image' => null,
                'video' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'footer',
                'status' => true,
                'clicks' => 22,
            ],
        ];

        foreach ($ads as $ad) {
            Advertisement::updateOrCreate(
                ['title' => $ad['title']],
                $ad
            );
        }
    }
}
