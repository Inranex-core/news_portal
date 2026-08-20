<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\JournalistProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BilingualArticleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure reporter exists
        $user = User::updateOrCreate(
            ['email' => 'journalist@newsportal.test'],
            [
                'name' => 'Senior Journalist',
                'password' => Hash::make('password123'),
                'role' => 'journalist',
            ]
        );

        $profile = JournalistProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'slug' => 'senior-journalist',
                'designation' => 'Senior News Editor',
                'designation_bn' => 'সিনিয়র বার্তা সম্পাদক',
                'organization' => 'News Portal Desk',
                'organization_bn' => 'নিউজ পোর্টাল ডেক্স',
                'bio' => 'Experienced news editor and investigative reporter.',
                'bio_bn' => 'অভিজ্ঞ সংবাদ সম্পাদক ও অনুসন্ধানী সাংবাদিক।',
                'is_verified' => true,
                'status' => true,
            ]
        );

        // 2. Fetch categories
        $campusCat = Category::where('slug', 'campus')->first();
        $politicsCat = Category::where('slug', 'politics')->first();
        $techCat = Category::where('slug', 'technology')->first();
        $sportsCat = Category::where('slug', 'sports')->first();
        $eduCat = Category::where('slug', 'education')->first();

        // 3. Articles Array
        $bilingualArticles = [
            // Campus Article
            [
                'category_id' => $campusCat?->id ?? 1,
                'title' => 'University Announces New AI & Robotics Research Lab',
                'title_bn' => 'বিশ্ববিদ্যালয়ে নতুন কৃত্রিম বুদ্ধিমত্তা ও রোবোটিক্স গবেষণা ল্যাব উদ্বোধন',
                'excerpt' => 'A state-of-the-art research facility has been launched to boost student innovation.',
                'excerpt_bn' => 'শিক্ষার্থীদের উদ্ভাবনী দক্ষতা বৃদ্ধিতে একটি অত্যাধুনিক গবেষণা কেন্দ্র চালু করা হয়েছে।',
                'content' => "The University Senate today officially inaugurated the country's largest AI & Robotics Innovation Hub on campus. The facility features high-performance computing clusters and advanced automation labs.\n\nStudents and researchers will work on cutting-edge projects including autonomous drone navigation and Bengali NLP models. Campus authorities announced full scholarships for top researchers.",
                'content_bn' => "বিশ্ববিদ্যালয় সিনেট আজ আনুষ্ঠানিকভাবে ক্যাম্পাসে দেশের বৃহত্তম কৃত্রিম বুদ্ধিমত্তা ও রোবোটিক্স ইনোভেশন হাবের উদ্বোধন করেছে। এই সুবিধায় উচ্চগতির কম্পিউটিং ক্লাস্টার এবং উন্নত অটোমেশন ল্যাব রয়েছে।\n\nশিক্ষার্থী ও গবেষকরা স্বায়ত্তশাসিত ড্রোন এবং বাংলা ভাষা প্রক্রিয়াকরণ মডেল সহ অত্যাধুনিক প্রকল্পে কাজ করবেন। ক্যাম্পাস কর্তৃপক্ষ শীর্ষ গবেষকদের জন্য পূর্ণাঙ্গ বৃত্তির ঘোষণা দিয়েছে।",
                'views' => 1240,
            ],

            // Politics Article
            [
                'category_id' => $politicsCat?->id ?? 2,
                'title' => 'National Electoral Reform Bill Passed in Parliament',
                'title_bn' => 'জাতীয় নির্বাচনী সংস্কার বিল সংসদে পাস',
                'excerpt' => 'Lawmakers voted unanimously for modernizing voting procedures and digital verification.',
                'excerpt_bn' => 'ভোটিং পদ্ধতি আধুনিকীকরণ ও ডিজিটাল যাচাইয়ের লক্ষ্যে আইনপ্রণেতারা সর্বসম্মতিক্রমে বিলটি পাস করেন।',
                'content' => "In a historic session, Parliament passed the Electoral Transparency Act today. The new bill enforces mandatory biometrics verification and strict campaign finance limits.\n\nOpposition leaders welcomed the consensus, stating that transparent voting is the foundation of robust democracy.",
                'content_bn' => "একটি ঐতিহাসিক অধিবেশনে আজ জাতীয় সংসদ নির্বাচনী স্বচ্ছতা আইন পাস করেছে। নতুন এই বিলে বাধ্যতামূলক বায়োমেট্রিক যাচাইকরণ এবং প্রচারণার অর্থায়নে কঠোর সীমা আরোপের কথা বলা হয়েছে।\n\nবিরোধী দলীয় নেতারা এই সিদ্ধান্তকে স্বাগত জানিয়ে বলেন, স্বচ্ছ ভোটিং পদ্ধতিই শক্তিশালী গণতন্ত্রের মূল ভিত্তি।",
                'views' => 2890,
            ],

            // Technology Article
            [
                'category_id' => $techCat?->id ?? 5,
                'title' => '5G Network Expansion Reaches 50 Disticts',
                'title_bn' => '৫০টি জেলায় বিস্তার লাভ করল ৫জি নেটওয়ার্ক',
                'excerpt' => 'High-speed mobile internet infrastructure expands to rural and semi-urban regions.',
                'excerpt_bn' => 'গ্রামীণ ও উপশহরাঞ্চলে উচ্চগতির মোবাইল ইন্টারনেট অবকাঠামো প্রসারিত হচ্ছে।',
                'content' => "Telecommunication authorities confirmed today that ultra-fast 5G broadband service is now active in 50 districts nationwide. The expansion is expected to empower local e-commerce, smart agriculture, and telemedicine.",
                'content_bn' => "টেলিযোগাযোগ কর্তৃপক্ষ আজ নিশ্চিত করেছে যে সারাদেশে ৫০টি জেলায় এখন অতি-দ্রুত ৫জি ব্রডব্যান্ড সেবা চালু রয়েছে। এই সম্প্রসারণ স্থানীয় ই-কমার্স, স্মার্ট কৃষি এবং টেলিমেডিসিনকে আরও শক্তিশালী করবে।",
                'views' => 950,
            ],

            // Sports Article
            [
                'category_id' => $sportsCat?->id ?? 4,
                'title' => 'National Cricket Team Wins Thrilling Final Match',
                'title_bn' => 'রোমাঞ্চকর ফাইনালে জাতীয় ক্রিকেট দলের ঐতিহাসিক জয়',
                'excerpt' => 'A stellar all-round performance secures victory on the final over.',
                'excerpt_bn' => 'শেষ ওভারে দুর্দান্ত অলরাউন্ড নৈপুণ্যে শিরোপা নিশ্চিত করেছে জাতীয় দল।',
                'content' => "Fans erupted in celebration as the national team clinched the championship trophy in a nerve-wracking last-over thriller. Chasing a formidable target of 280, the middle-order partnership held strong to hit the winning boundaries.",
                'content_bn' => "শেষ ওভারের রোমাঞ্চকর লড়াইয়ে চ্যাম্পিয়নশিপ ট্রফি জয়ে উল্লাসে ফেটে পড়েন সমর্থকরা। ২৮০ রানের কঠিন লক্ষ্য তাড়া করতে নেমে মিডল অর্ডারের দৃঢ় জুটিতে জয় নিশ্চিত হয়।",
                'views' => 3120,
            ],

            // Education Article
            [
                'category_id' => $eduCat?->id ?? 8,
                'title' => 'New Digital Curriculum Rolled Out Nationwide',
                'title_bn' => 'সারাদেশে নতুন ডিজিটাল পাঠ্যক্রমের শুভ সূচনা',
                'excerpt' => 'Schools receive updated interactive learning tools and STEM coding modules.',
                'excerpt_bn' => 'বিদ্যালয়সমূহে ইন্টারঅ্যাক্টিভ লার্নিং টুলস এবং স্টেম কোডিং মডিউল চালু করা হয়েছে।',
                'content' => "Education Ministry launched the revised digital curriculum across secondary schools today. Teachers have undergone specialized training to integrate coding, problem solving, and environmental science into daily classes.",
                'content_bn' => "শিক্ষা মন্ত্রণালয় আজ মাধ্যমিক বিদ্যালয়সমূহে নতুন ডিজিটাল পাঠ্যক্রম চালু করেছে। ক্লাসরুমে কোডিং, সমস্যা সমাধান এবং পরিবেশ বিজ্ঞান অন্তর্ভুক্ত করার জন্য শিক্ষকদের বিশেষ প্রশিক্ষণ দেওয়া হয়েছে।",
                'views' => 1560,
            ],
        ];

        foreach ($bilingualArticles as $index => $data) {
            $title = $data['title'];
            $slug = Str::slug($title);

            Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'journalist_profile_id' => $profile->id,
                    'category_id' => $data['category_id'],
                    'title' => $title,
                    'title_bn' => $data['title_bn'],
                    'excerpt' => $data['excerpt'],
                    'excerpt_bn' => $data['excerpt_bn'],
                    'content' => $data['content'],
                    'content_bn' => $data['content_bn'],
                    'status' => 'published',
                    'published_at' => now()->subHours($index * 3),
                    'views' => $data['views'],
                ]
            );
        }
    }
}
