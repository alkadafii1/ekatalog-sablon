<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReplyLike;
use App\Models\ReviewLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menampilkan semua ulasan untuk toko dengan replies
    public function index()
    {
        $reviews = Review::with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    // Menyimpan ulasan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ], [
            'comment.required' => 'The comment field must not be empty.'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    // Like review
    public function likeReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $user = Auth::user();

        // Cek apakah user sudah like review ini
        $existingLike = ReplyLike::where('review_id', $review->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            // Jika sudah like, hapus like (unlike)
            $existingLike->delete();
            $review->decrement('likes_count');
            $isLiked = false;
        } else {
            // Jika belum like, tambahkan like
            ReplyLike::create([
                'review_id' => $review->id,
                'user_id' => $user->id,
            ]);
            $review->increment('likes_count');
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'likes_count' => $review->fresh()->likes_count,
            'is_liked' => $isLiked
        ]);
    }

    // Update review
    public function update(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Authorization check
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit ulasan ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $review->update($validated);

        return back()->with('success', 'Ulasan berhasil diperbarui!');
    }

    // Hapus review
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Authorization check
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus ulasan ini.');
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}