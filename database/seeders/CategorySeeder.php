<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bangladesh',
                'name_bn' => 'বাংলাদেশ',
                'description' => 'Latest news from Bangladesh.',
            ],
            [
                'name' => 'Politics',
                'name_bn' => 'রাজনীতি',
                'description' => 'Political news and updates.',
            ],
            [
                'name' => 'Campus',
                'name_bn' => 'ক্যাম্পাস',
                'description' => 'University, college and campus news.',
            ],
            [
                'name' => 'Sports',
                'name_bn' => 'খেলাধুলা',
                'description' => 'Sports news, scores and updates.',
            ],
            [
                'name' => 'Technology',
                'name_bn' => 'প্রযুক্তি',
                'description' => 'Technology and innovation news.',
            ],
            [
                'name' => 'Business',
                'name_bn' => 'বাণিজ্য',
                'description' => 'Business, economy and finance news.',
            ],
            [
                'name' => 'Entertainment',
                'name_bn' => 'বিনোদন',
                'description' => 'Entertainment and celebrity news.',
            ],
            [
                'name' => 'Education',
                'name_bn' => 'শিক্ষা',
                'description' => 'Education and academic news.',
            ],
            [
                'name' => 'Health',
                'name_bn' => 'স্বাস্থ্য',
                'description' => 'Health and medical news.',
            ],
            [
                'name' => 'International',
                'name_bn' => 'আন্তর্জাতিক',
                'description' => 'International news and updates.',
            ],
            [
                'name' => 'Lifestyle',
                'name_bn' => 'জীবনযাপন',
                'description' => 'Lifestyle, travel and culture news.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'slug' => Str::slug($category['name']),
                ],
                [
                    'name' => $category['name'],
                    'name_bn' => $category['name_bn'],
                    'description' => $category['description'],
                    'status' => true,
                ]
            );
        }
    }
}