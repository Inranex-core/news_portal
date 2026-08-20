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
                'title' => 'Special Admission Discount - Comilla University Computer Science & IT',
                'image' => null,
                'url' => 'https://cou.ac.bd',
                'placement' => 'header_top',
                'status' => true,
            ],
            [
                'title' => 'Tech Masterclass 2026 - Register Now for 50% Off!',
                'image' => null,
                'url' => 'https://couja.news',
                'placement' => 'sidebar',
                'status' => true,
            ],
            [
                'title' => 'CoUJA Annual Journalism Conference & Award 2026',
                'image' => null,
                'url' => 'https://couja.news/journalists',
                'placement' => 'in_article',
                'status' => true,
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
