<?php

namespace Database\Seeders;

use App\Models\Expertise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExpertiseSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Bangladesh',
            'Politics',
            'Sports',
            'Technology',
            'Science',
            'Health',
            'Education',
            'Business',
            'Entertainment',
            'International',
            'Crime',
            'Lifestyle',
            'Environment',
            'Economy',
        ];

        foreach ($items as $name) {
            Expertise::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => null,
                    'status' => true,
                ]
            );
        }
    }
}