<?php

namespace Tests\Feature\Reply;

use App\Models\Reply;
use App\Models\Review;
use App\Models\User;
use App\Models\ReplyLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    // -----------------------
    // Basic CRUD & Like Tests
    // -----------------------

    #[Test]
    public function rep001_user_can_create_reply()
    {
        // User dan review
        $user = User::factory()->create();
        $review = Review::factory()->create();

        // Act: membuat reply
        $this->actingAs($user)
            ->post(route('replies.store', $review->id), [
                'comment' => 'Balasan tes',
            ])
            ->assertRedirect();

        // Assert: reply tercatat di DB
        $this->assertDatabaseHas('replies', [
            'review_id' => $review->id,
            'user_id' => $user->id,
            'comment' => 'Balasan tes',
        ]);
    }

    #[Test]
    public function rep002_user_can_update_own_reply()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put(route('replies.update', $reply->id), [
                'comment' => 'Balasan diperbarui',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'comment' => 'Balasan diperbarui',
        ]);
    }

    #[Test]
    public function rep003_user_cannot_update_others_reply()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->put(route('replies.update', $reply->id), [
                'comment' => 'Percobaan update',
            ])
            ->assertRedirect()
            ->assertSessionHas('error');

        // Komentar tetap sama
        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'comment' => $reply->comment,
        ]);
    }

    #[Test]
    public function rep004_user_can_delete_own_reply()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('replies.destroy', $reply->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('replies', [
            'id' => $reply->id,
        ]);
    }

    #[Test]
    public function rep005_user_cannot_delete_others_reply()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->delete(route('replies.destroy', $reply->id))
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
        ]);
    }

    #[Test]
    public function rep006_user_can_like_and_unlike_reply()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create();

        // Like pertama
        $response = $this->actingAs($user)
            ->postJson(route('replies.like', $reply->id));

        $response->assertJson([
            'success' => true,
            'is_liked' => true,
        ]);

        $this->assertDatabaseHas('reply_likes', [
            'reply_id' => $reply->id,
            'user_id' => $user->id,
        ]);

        // Unlike
        $response = $this->actingAs($user)
            ->postJson(route('replies.like', $reply->id));

        $response->assertJson([
            'success' => true,
            'is_liked' => false,
        ]);

        $this->assertDatabaseMissing('reply_likes', [
            'reply_id' => $reply->id,
            'user_id' => $user->id,
        ]);
    }

    // -----------------------
    // Edge Case Tests
    // -----------------------

    #[Test]
    public function rep007_cannot_reply_to_deleted_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();
        $review->delete();

        // Act: reply ke review yg sudah dihapus
        $this->actingAs($user)
            ->post(route('replies.store', $review->id), [
                'comment' => 'Balasan gagal',
            ])
            ->assertStatus(404);

        $this->assertDatabaseMissing('replies', [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function rep008_rapid_like_unlike_reply()
    {
        $user = User::factory()->create();
        $reply = Reply::factory()->create();

        // Rapid like/unlike 5x
        for ($i = 0; $i < 5; $i++) {
            $this->actingAs($user)
                ->postJson(route('replies.like', $reply->id));
        }

        // likes_count harus 0 atau 1
        $reply->refresh();
        $this->assertContains($reply->likes_count, [0,1]);

        // Jumlah row di reply_likes sesuai likes_count
        $this->assertEquals(
            ReplyLike::where('reply_id', $reply->id)->count(),
            $reply->likes_count
        );
    }

    // -----------------------
    // Optional: Load/Performance Test Skeleton
    // -----------------------
    #[Test]
    public function rep009_many_replies_per_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        // Simulasi 100 reply
        Reply::factory()->count(100)->create([
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals(100, Reply::where('review_id', $review->id)->count());
    }
}
