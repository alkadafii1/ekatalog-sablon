<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // TC001 - ProfileController@edit
    public function test_profile_page_is_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/profile');
        $response->assertOk();
    }

    // TC002 - ProfileController@edit (BARU)
    public function test_guest_cannot_access_profile_page()
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    // TC001 - ProfileController@update
    public function test_profile_information_can_be_updated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch('/profile', [
            'name' => 'Wulan',
            'email' => 'wulan@email.com',
        ]);

        $response->assertSessionHasNoErrors()
                ->assertRedirect('/profile');
        $response->assertSessionHas('status', 'profile-updated'); // Pastikan ada pesan sukses
        
        $user->refresh();
        $this->assertSame('Wulan', $user->name);
        $this->assertSame('wulan@email.com', $user->email);
    }

    // TC002 - ProfileController@update
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    // Test tambahan untuk email verification reset
    public function test_email_verification_reset_when_email_changed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch('/profile', [
            'name' => 'Test User',
            'email' => 'newemail@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $user->refresh();
        $this->assertSame('newemail@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    // TC003 - ProfileController@update (BARU)
    public function test_update_profile_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Test dengan data invalid
        $response = $this->patch('/profile', [
            'name' => '',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    // TC001 - ProfileController@destroy
    public function test_user_can_delete_their_account()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    // TC002 - ProfileController@destroy
    public function test_correct_password_must_be_provided_to_delete_account()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete('/profile', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertNotNull($user->fresh());
    }

    // TC003 - ProfileController@destroy (BARU)
    public function test_guest_cannot_delete_account()
    {
        $response = $this->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertRedirect('/login');
    }
}