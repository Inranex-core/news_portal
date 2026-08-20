<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\JournalistProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed categories
        Category::create([
            'name' => 'Politics',
            'slug' => 'politics',
            'status' => true,
        ]);
        
        Category::create([
            'name' => 'Campus',
            'slug' => 'campus',
            'status' => true,
        ]);
    }

    /** Test user registration */
    public function test_user_can_register_as_normal_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'General Reader',
            'email' => 'reader@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'reader@example.com',
            'role' => 'user',
        ]);
    }

    /** Test journalist registration */
    public function test_user_can_register_as_journalist_and_profile_is_created(): void
    {
        $response = $this->post('/register', [
            'name' => 'Reporter John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'journalist',
        ]);

        $response->assertRedirect('/dashboard');
        
        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('journalist', $user->role);
        $this->assertNotNull($user->journalistProfile);
        $this->assertEquals('reporter-john', $user->journalistProfile->slug);
    }

    /** Test login redirection for admin, journalist, user */
    public function test_login_redirects_to_correct_role_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertRedirect(route('admin.dashboard'));

        $journalistUser = User::create([
            'name' => 'Journalist User',
            'email' => 'journalist@example.com',
            'password' => bcrypt('password123'),
            'role' => 'journalist',
        ]);
        JournalistProfile::create([
            'user_id' => $journalistUser->id,
            'slug' => 'journalist-user',
        ]);

        $response = $this->actingAs($journalistUser)->get('/dashboard');
        $response->assertRedirect(route('journalist.dashboard'));

        $normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'normal@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($normalUser)->get('/dashboard');
        $response->assertRedirect(route('user.dashboard'));
    }

    /** Test journalist news article upload and submit */
    public function test_journalist_can_create_and_submit_article(): void
    {
        $journalistUser = User::create([
            'name' => 'Reporter Jane',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'role' => 'journalist',
        ]);

        $profile = JournalistProfile::create([
            'user_id' => $journalistUser->id,
            'slug' => 'reporter-jane',
        ]);

        $category = Category::where('slug', 'campus')->first();

        $response = $this->actingAs($journalistUser)->post('/journalist/articles', [
            'title' => 'Campus New Library Opening',
            'category_id' => $category->id,
            'excerpt' => 'A new modern library was opened today.',
            'content' => 'Full article content for the campus new library opening...',
            'action' => 'submit',
        ]);

        $response->assertRedirect(route('journalist.articles.index'));
        $this->assertDatabaseHas('articles', [
            'journalist_profile_id' => $profile->id,
            'category_id' => $category->id,
            'title' => 'Campus New Library Opening',
            'status' => 'pending',
        ]);
    }

    /** Test admin approval and rejection workflow */
    public function test_admin_can_approve_and_reject_articles_and_verify_journalists(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $journalistUser = User::create([
            'name' => 'Reporter Mark',
            'email' => 'mark@example.com',
            'password' => bcrypt('password123'),
            'role' => 'journalist',
        ]);

        $profile = JournalistProfile::create([
            'user_id' => $journalistUser->id,
            'slug' => 'reporter-mark',
            'is_verified' => false,
        ]);

        $category = Category::where('slug', 'politics')->first();

        $article = Article::create([
            'journalist_profile_id' => $profile->id,
            'category_id' => $category->id,
            'title' => 'Political Summit 2026',
            'slug' => 'political-summit-2026',
            'excerpt' => 'Summit summary',
            'content' => 'Full content...',
            'status' => 'pending',
        ]);

        // Admin verifies journalist
        $response = $this->actingAs($admin)->patch(route('admin.journalists.verification', $profile->id));
        $this->assertTrue($profile->fresh()->is_verified);

        // Admin approves pending article
        $response = $this->actingAs($admin)->patch(route('admin.articles.approve', $article->id));
        $response->assertRedirect(route('admin.articles.pending'));
        $this->assertEquals('published', $article->fresh()->status);
        $this->assertNotNull($article->fresh()->published_at);
    }
}
