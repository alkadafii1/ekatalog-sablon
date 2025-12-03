<?php

namespace Tests\Feature\Google;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    // ===============================
    // Helper untuk mock Google User
    // ===============================
    protected function mockGoogleUser(string $email, string $name = 'Test User')
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Contracts\User');
        $abstractUser->shouldReceive('getEmail')->andReturn($email);
        $abstractUser->shouldReceive('getName')->andReturn($name);

        Socialite::shouldReceive('driver->stateless->user')->andReturn($abstractUser);
    }

    #[Test] // GL001
    public function gl001_user_can_redirect_to_google()
    {
        $response = $this->get(route('auth.google'));
        $response->assertRedirect();
    }

    #[Test] // GL002
    public function gl002_user_can_login_via_google()
    {
        $this->mockGoogleUser('newuser@example.com');

        $this->get('/auth/google/callback');

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user, 'User baru harus tercipta');
    }

    #[Test] // GL003
    public function gl003_existing_user_can_login_without_creating_new()
    {
        User::factory()->create(['email' => 'existing@example.com']);
        $this->mockGoogleUser('existing@example.com', 'Existing User');

        $this->get('/auth/google/callback');

        $users = User::where('email', 'existing@example.com')->get();
        $this->assertCount(1, $users, 'Tidak boleh membuat user baru jika sudah ada');
    }

    #[Test] // GL004
    public function gl004_user_password_is_dummy()
    {
        $this->mockGoogleUser('dummy@example.com');

        $this->get('/auth/google/callback');

        $user = User::where('email', 'dummy@example.com')->first();
        $this->assertTrue(password_verify('google_dummy', $user->password), 'Password harus dummy');
    }

    #[Test] // GL005
    public function gl005_email_verified_after_google_login()
    {
        $this->mockGoogleUser('verified@example.com');

        $this->get('/auth/google/callback');

        $user = User::where('email', 'verified@example.com')->first();

        $this->assertNotNull($user, 'User tidak tercipta setelah login Google');
        $this->assertNotNull($user->email_verified_at, 'Email belum diverifikasi');
    }
}
