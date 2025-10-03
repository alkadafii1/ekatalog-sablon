<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reply;
use App\Models\ReplyLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // Menyimpan balasan untuk review tertentu
    public function store(Request $request, $reviewId)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $review = Review::findOrFail($reviewId);

        $reply = Reply::create([
            'review_id' => $review->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }

    // Like balasan
    public function like($replyId)
    {
        $reply = Reply::findOrFail($replyId);
        $user = Auth::user();

        // Cek apakah user sudah like balasan ini
        $existingLike = ReplyLike::where('reply_id', $reply->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            // Jika sudah like, hapus like (unlike)
            $existingLike->delete();
            $reply->decrement('likes_count');
            $message = 'Like dihapus';
        } else {
            // Jika belum like, tambahkan like
            ReplyLike::create([
                'reply_id' => $reply->id,
                'user_id' => $user->id,
            ]);
            $reply->increment('likes_count');
            $message = 'Balasan disukai';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'likes_count' => $reply->fresh()->likes_count,
            'is_liked' => !$existingLike
        ]);
    }

    // Update balasan
    public function update(Request $request, $replyId)
    {
        $reply = Reply::findOrFail($replyId);

        // Authorization check - hanya pemilik yang bisa edit
        if ($reply->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit balasan ini.');
        }

        $validated = $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $reply->update([
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Balasan berhasil diperbarui!');
    }

    // Hapus balasan
    public function destroy($replyId)
    {
        $reply = Reply::findOrFail($replyId);

        // Authorization check - hanya pemilik atau admin yang bisa hapus
        if ($reply->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus balasan ini.');
        }

        $reply->delete();

        return back()->with('success', 'Balasan berhasil dihapus!');
    }
}