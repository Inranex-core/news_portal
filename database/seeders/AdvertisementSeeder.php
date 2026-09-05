<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            [
                'title' => 'Tech Masterclass 2026 - Register Now for 50% Off!',
                'image' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'sidebar',
                'status' => true,
                'clicks' => 45,
            ],
            [
                'title' => 'CoUJA Annual Journalism Conference & Award 2026',
                'image' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'in_article',
                'status' => true,
                'clicks' => 28,
            ],
            [
                'title' => 'National IT Olympiad 2026 - CoU Campus Campaign',
                'image' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'footer',
                'status' => true,
                'clicks' => 9,
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
