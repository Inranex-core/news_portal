<?php

namespace Database\Seeders;

use App\Models\JournalistProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Account
        User::updateOrCreate(
            ['email' => 'syedminhaz365@gmail.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Journalist Account
        $journalistUser = User::updateOrCreate(
            ['email' => 'journalist@newsportal.test'],
            [
                'name' => 'Senior Journalist',
                'password' => Hash::make('password123'),
                'role' => 'journalist',
            ]
        );

        JournalistProfile::updateOrCreate(
            ['user_id' => $journalistUser->id],
            [
                'slug' => 'senior-journalist',
                'designation' => 'Senior News Editor',
                'organization' => 'News Portal Desk',
                'bio' => 'Experienced news editor and investigative reporter covering national & campus news.',
                'is_verified' => true,
                'status' => true,
            ]
        );

        // 3. Normal User Account
        User::updateOrCreate(
            ['email' => 'user@newsportal.test'],
            [
                'name' => 'General Reader',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        $this->call([
            ExpertiseSeeder::class,
            CategorySeeder::class,
            AdvertisementSeeder::class,
            BilingualArticleSeeder::class,
        ]);
    }
}
