<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Review;
use App\Models\ReplyLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_all_reviews_in_index_page()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/reviews');

        $response->assertStatus(200);
        $response->assertViewIs('reviews.index');
        $response->assertViewHas('reviews');
    }

    #[Test]
    public function it_stores_a_valid_review()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/reviews', [
            'rating' => 5,
            'comment' => 'Produk bagus',
        ]);

        $response->assertRedirect('');
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Produk bagus',
        ]);
    }

    #[Test]
    public function it_fails_to_store_review_without_rating()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/reviews', [
            'comment' => 'Bagus banget',
        ]);

        $response->assertSessionHasErrors('rating');
    }

    #[Test]
    public function it_allows_user_to_like_and_unlike_a_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        // Like
        $response = $this->actingAs($user)->post("/reviews/{$review->id}/like");
        $response->assertJson(['success' => true, 'is_liked' => true]);
        $this->assertDatabaseHas('reply_likes', [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);

        // Unlike
        $response = $this->actingAs($user)->post("/reviews/{$review->id}/like");
        $response->assertJson(['success' => true, 'is_liked' => false]);
        $this->assertDatabaseMissing('reply_likes', [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function user_can_update_own_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put("/reviews/{$review->id}", [
            'rating' => 4,
            'comment' => 'Diperbarui sedikit',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'rating' => 4,
            'comment' => 'Diperbarui sedikit',
        ]);
    }

    #[Test]
    public function user_cannot_update_other_users_review()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->put("/reviews/{$review->id}", [
            'rating' => 4,
            'comment' => 'Ingin ubah',
        ]);

        $response->assertSessionHas('error', 'Anda tidak memiliki akses untuk mengedit ulasan ini.');
    }

    #[Test]
    public function user_can_delete_own_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/reviews/{$review->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    #[Test]
    public function admin_can_delete_any_review()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $review = Review::factory()->create();

        $response = $this->actingAs($admin)->delete("/reviews/{$review->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    #[Test]
    public function non_owner_and_non_admin_cannot_delete_review()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create(['is_admin' => false]);
        $review = Review::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->delete("/reviews/{$review->id}");

        $response->assertSessionHas('error', 'Anda tidak memiliki akses untuk menghapus ulasan ini.');
    }
}
