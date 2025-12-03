<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // =========================
    // Update Informasi Profil
    // =========================

    // Test ID: PF001
    #[Test]
    public function profile_information_can_be_updated()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('new@example.com', $user->email);
    }

    // Test ID: PF002
    #[Test]
    public function profile_update_fails_with_invalid_email()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->patch(route('profile.update'), [
            'name' => 'Name',
            'email' => 'invalid-email',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('email');

        $user->refresh();
        $this->assertNotEquals('invalid-email', $user->email);
    }

    // =========================
    // Update Password
    // =========================

    // Test ID: PF003
    #[Test]
    public function password_can_be_updated_with_correct_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $this->actingAs($user);

        $response = $this->put(route('password.update'), [
            'current_password' => 'oldpassword123',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'password-updated');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword456', $user->password));
    }

    // Test ID: PF004
    #[Test]
    public function password_update_fails_with_wrong_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->put(route('password.update'), [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('current_password', null, 'updatePassword');

        $user->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $user->password));
    }

    // Test ID: PF005
    #[Test]
    public function password_update_fails_when_password_confirmation_does_not_match()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->put(route('password.update'), [
            'current_password' => 'oldpassword123',
            'password' => 'newpassword456',
            'password_confirmation' => 'mismatch456',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('password', null, 'updatePassword');

        $user->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $user->password));
    }

    // =========================
    // Delete Akun
    // =========================

    // Test ID: PF006
    #[Test]
    public function user_can_delete_their_account_with_correct_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('mypassword123'),
        ]);

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->delete(route('profile.destroy'), [
            'password' => 'mypassword123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // Test ID: PF007
    #[Test]
    public function user_cannot_delete_account_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('mypassword123'),
        ]);

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->delete(route('profile.destroy'), [
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('password', null, 'userDeletion');

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
