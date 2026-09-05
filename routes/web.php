<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JournalistController as AdminJournalistController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Journalist\ArticleController;
use App\Http\Controllers\Journalist\AwardController;
use App\Http\Controllers\Journalist\DashboardController as JournalistDashboardController;
use App\Http\Controllers\Journalist\EducationController;
use App\Http\Controllers\Journalist\ExperienceController;
use App\Http\Controllers\Journalist\ExpertiseController;
use App\Http\Controllers\Journalist\ProfileSetupController;

use App\Http\Controllers\JournalistController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PublicNewsController;

/*
|--------------------------------------------------------------------------
| Public News Portal Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicNewsController::class, 'index'])->name('home');
Route::get('/news/{slug}', [PublicNewsController::class, 'showArticle'])->name('articles.show');
Route::post('/news/{slug}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('articles.comments.store');
Route::get('/category/{slug}', [PublicNewsController::class, 'showCategory'])->name('categories.show');
Route::get('/ad/click/{advertisement}', [\App\Http\Controllers\Admin\AdvertisementController::class, 'trackClick'])->name('ads.click');

Route::get('/journalists', [JournalistController::class, 'index'])->name('journalists.index');
Route::get('/journalists/{slug}', [JournalistController::class, 'show'])->name('journalists.show');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['bn', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');




/*
|--------------------------------------------------------------------------
| Main Dashboard
|--------------------------------------------------------------------------
|
| Login করার পরে user's role অনুযায়ী
| DashboardController redirect করবে।
|
*/

Route::get('/dashboard', [
    DashboardController::class,
    'redirect',
])
    ->middleware('auth')
    ->name('dashboard');


use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Middleware\EnsureJournalistApproved;

/*
|--------------------------------------------------------------------------
| OTP Verification Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
    Route::post('/verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.submit');
    Route::post('/resend-otp', [OtpVerificationController::class, 'resend'])->name('otp.resend');
});

/*
|--------------------------------------------------------------------------
| Journalist Registration & Invite Public Activation Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/journalist/pending-approval', function () {
        return view('journalist.pending_approval');
    })->name('journalist.pending');
});

Route::get('/journalist/accept-invite/{token}', [AdminJournalistController::class, 'acceptInviteShow'])->name('journalist.accept_invite');
Route::post('/journalist/accept-invite/{token}', [AdminJournalistController::class, 'acceptInviteSubmit'])->name('journalist.accept_invite.submit');

/*
|--------------------------------------------------------------------------
| Normal User Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:user'
])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

    });


/*
|--------------------------------------------------------------------------
| Journalist Routes
|--------------------------------------------------------------------------
|
| সব Journalist functionality এখানে থাকবে।
|
| /journalist/dashboard
| /journalist/profile/edit
| /journalist/experience
| /journalist/education
| /journalist/award
| /journalist/expertise
| /journalist/articles
|
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'role:journalist',
    EnsureJournalistApproved::class,
])
    ->prefix('journalist')
    ->name('journalist.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Journalist Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            JournalistDashboardController::class,
            'index',
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Complete Journalist Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile/edit', [
            ProfileSetupController::class,
            'edit',
        ])->name('profile.edit');


        /*
        |--------------------------------------------------------------------------
        | Profile Setup Compatibility Route
        |--------------------------------------------------------------------------
        */

        Route::get('/profile/setup', function () {

            return redirect()->route(
                'journalist.profile.edit'
            );

        })->name('profile.setup');


        /*
        |--------------------------------------------------------------------------
        | Update Complete Profile
        |--------------------------------------------------------------------------
        */

        Route::patch('/profile/setup', [
            ProfileSetupController::class,
            'update',
        ])->name('profile.setup.update');


        /*
        |--------------------------------------------------------------------------
        | Profile Update Compatibility Route
        |--------------------------------------------------------------------------
        */

        Route::patch('/profile', [
            ProfileSetupController::class,
            'update',
        ])->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | Experience
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'experience',
            ExperienceController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Education
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'education',
            EducationController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Awards
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'award',
            AwardController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Expertise
        |--------------------------------------------------------------------------
        */

        Route::get('/expertise', [
            ExpertiseController::class,
            'index',
        ])->name('expertise.index');


        Route::patch('/expertise', [
            ExpertiseController::class,
            'update',
        ])->name('expertise.update');


        /*
        |--------------------------------------------------------------------------
        | NEWS / ARTICLES
        |--------------------------------------------------------------------------
        |
        | Journalist এখান থেকে নিজের news manage করবে।
        |
        */

        Route::get('/articles', [
            ArticleController::class,
            'index'
        ])->name('articles.index');


        Route::get('/articles/create', [
            ArticleController::class,
            'create'
        ])->name('articles.create');


        Route::post('/articles', [
            ArticleController::class,
            'store'
        ])->name('articles.store');

        Route::patch('/articles/{article}/submit', [
    ArticleController::class,
    'submit',
])->name('articles.submit');


        Route::get('/articles/{article}/edit', [
            ArticleController::class,
            'edit'
        ])->name('articles.edit');

        Route::match(['put', 'patch'], '/articles/{article}', [
            ArticleController::class,
            'update'
        ])->name('articles.update');


        Route::delete('/articles/{article}', [
            ArticleController::class,
            'destroy'
        ])->name('articles.destroy');


    });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin'
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index',
        ])->name('dashboard');

        /* Email Journalist */
        Route::get('/email/{journalist?}', [\App\Http\Controllers\Admin\EmailController::class, 'create'])->name('email.create');
        Route::post('/email/send', [\App\Http\Controllers\Admin\EmailController::class, 'send'])->name('email.send');


        /*
        |--------------------------------------------------------------------------
        | All Journalists
        |--------------------------------------------------------------------------
        */

        Route::get('/journalists', [
            AdminJournalistController::class,
            'index',
        ])->name('journalists.index');

        Route::get('/journalists/pending', [
            AdminJournalistController::class,
            'pending',
        ])->name('journalists.pending');

        Route::patch('/journalists/{user}/approve', [
            AdminJournalistController::class,
            'approve',
        ])->name('journalists.approve');

        Route::delete('/journalists/{user}/reject', [
            AdminJournalistController::class,
            'reject',
        ])->name('journalists.reject');

        Route::post('/journalists/invite', [
            AdminJournalistController::class,
            'sendInvite',
        ])->name('journalists.invite');


        /*
        |--------------------------------------------------------------------------
        | Single Journalist
        |--------------------------------------------------------------------------
        */

        Route::get('/journalists/{journalist}', [
            AdminJournalistController::class,
            'show',
        ])->name('journalists.show');


        /*
        |--------------------------------------------------------------------------
        | Verify / Unverify Journalist
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/journalists/{journalist}/verification',
            [
                AdminJournalistController::class,
                'toggleVerification',
            ]
        )->name('journalists.verification');

/*
|--------------------------------------------------------------------------
| Article Management
|--------------------------------------------------------------------------
*/

Route::get('/articles', [
    \App\Http\Controllers\Admin\ArticleController::class,
    'index'
])->name('articles.index');


Route::get('/articles/pending', [
    \App\Http\Controllers\Admin\ArticleController::class,
    'pending'
])->name('articles.pending');


Route::get('/articles/{article}', [
    \App\Http\Controllers\Admin\ArticleController::class,
    'show'
])->name('articles.show');


Route::patch('/articles/{article}/approve', [
    \App\Http\Controllers\Admin\ArticleController::class,
    'approve'
])->name('articles.approve');


Route::patch('/articles/{article}/reject', [
    \App\Http\Controllers\Admin\ArticleController::class,
    'reject'
])->name('articles.reject');


/*
|--------------------------------------------------------------------------
| Advertisements
|--------------------------------------------------------------------------
*/
Route::get('/advertisements', [\App\Http\Controllers\Admin\AdvertisementController::class, 'index'])->name('advertisements.index');
Route::get('/advertisements/create', [\App\Http\Controllers\Admin\AdvertisementController::class, 'create'])->name('advertisements.create');
Route::post('/advertisements', [\App\Http\Controllers\Admin\AdvertisementController::class, 'store'])->name('advertisements.store');
Route::get('/advertisements/{advertisement}/edit', [\App\Http\Controllers\Admin\AdvertisementController::class, 'edit'])->name('advertisements.edit');
Route::put('/advertisements/{advertisement}', [\App\Http\Controllers\Admin\AdvertisementController::class, 'update'])->name('advertisements.update');
Route::patch('/advertisements/{advertisement}/toggle', [\App\Http\Controllers\Admin\AdvertisementController::class, 'toggleStatus'])->name('advertisements.toggle');
Route::delete('/advertisements/{advertisement}', [\App\Http\Controllers\Admin\AdvertisementController::class, 'destroy'])->name('advertisements.destroy');



    });


/*
|--------------------------------------------------------------------------
| Normal Account Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])->name('profile.edit');


    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])->name('profile.update');


    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';