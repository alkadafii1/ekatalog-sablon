<?php

namespace Tests\Feature\Review;

use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $otherUser;
    protected Review $reviewOther;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->reviewOther = Review::factory()->create([
            'user_id' => $this->otherUser->id,
            'rating' => 4,
            'comment' => 'Review tes',
            'likes_count' => 0,
        ]);
    }

    #[Test]
    public function rev001_user_can_create_review()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('reviews.store'), [
            'rating' => 4,
            'comment' => 'Review tes',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'comment' => 'Review tes',
        ]);
    }

    #[Test]
    public function rev002_user_can_update_own_review()
    {
        $this->actingAs($this->user);

        $review = Review::factory()->create([
            'user_id' => $this->user->id,
            'rating' => 4,
            'comment' => 'Review tes',
            'likes_count' => 0,
        ]);

        $response = $this->put(route('reviews.update', $review->id), [
            'rating' => 3,
            'comment' => 'Review diperbarui',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'comment' => 'Review diperbarui',
        ]);
    }

    #[Test]
    public function rev003_user_cannot_update_others_review()
    {
        $this->actingAs($this->user);

        $response = $this->put(route('reviews.update', $this->reviewOther->id), [
            'rating' => 2,
            'comment' => 'Percobaan update',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('reviews', [
            'id' => $this->reviewOther->id,
            'comment' => 'Review tes',
        ]);
    }

    #[Test]
    public function rev004_user_can_delete_own_review()
    {
        $this->actingAs($this->user);

        $review = Review::factory()->create([
            'user_id' => $this->user->id,
            'rating' => 4,
            'comment' => 'Review tes',
            'likes_count' => 0,
        ]);

        $response = $this->delete(route('reviews.destroy', $review->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }

    #[Test]
    public function rev005_user_cannot_delete_others_review()
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('reviews.destroy', $this->reviewOther->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('reviews', [
            'id' => $this->reviewOther->id,
        ]);
    }
}
