@extends('layouts.apperance')

@section('title', 'Ulasan Toko')

@section('content')
<style>
    .star-rating .fa-star {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }

    .star-rating .fa-star.selected {
        color: #ffc107;
    }

    .alert-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .reply-section {
        margin-left: 30px;
        margin-top: 15px;
        padding: 10px;
        border-left: 2px solid #2196F3;
        background-color: #f5f5f5;
    }

    .reply-section .reply-title {
        font-weight: 600;
        font-size: 1rem;
        color: #333;
    }

    .reply-section .reply-comment {
        font-size: 0.9rem;
        color: #666;
        margin-top: 5px;
    }

    .reply-section small {
        color: #aaa;
        font-size: 0.8rem;
    }

    .reply-button {
        font-size: 14px;
        cursor: pointer;
        color: #2196F3;
    }

    .reply-button:hover {
        text-decoration: underline;
    }

    /* Love button */
    .love-button {
        cursor: pointer;
        color: #ff3366;
        margin-left: 15px;
        background: none;
        border: none;
        font-size: 14px;
    }

    .love-button:hover {
        color: #e6004c;
    }

    .review-actions, .reply-actions {
        margin-top: 10px;
    }

    .reply-form {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
</style>

{{-- NOTIFIKASI --}}
<div class="alert-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

{{-- Ulasan Toko --}}
<div class="card mb-4">
    <div class="card-header">
        <h5><i class="fas fa-comments me-2"></i>Ulasan Toko</h5>
    </div>
    <div class="card-body">
        @if($reviews->count())
            @foreach ($reviews as $review)
                <div class="mb-3 border-bottom pb-2 review-item" id="review-{{ $review->id }}">
                    <div class="review-header d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $review->user ? $review->user->name : 'Anonim ' . strtoupper(Str::random(5)) }}</strong> - 
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                            @endfor
                        </div>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="review-comment mt-2">{{ $review->comment }}</p>
                    
                    <div class="review-actions d-flex align-items-center">
                        {{-- Fitur Love untuk Review --}}
                        <button class="love-button" onclick="likeReview({{ $review->id }})">
                            ❤️ <span id="love-count-{{ $review->id }}">{{ $review->likes_count }}</span>
                        </button>

                        {{-- Tombol Balas --}}
                        <button class="btn btn-sm btn-outline-primary ms-2 reply-toggle" data-review-id="{{ $review->id }}">
                            <i class="fas fa-reply me-1"></i>Balas
                        </button>

                        {{-- Edit/Hapus untuk pemilik review --}}
                        @auth
                            @if(auth()->id() === $review->user_id)
                                <button class="btn btn-sm btn-outline-secondary ms-2 edit-review" data-review-id="{{ $review->id }}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus ulasan ini?')">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    {{-- Balasan Ulasan --}}
                    @if ($review->replies && $review->replies->count())
                        <div class="reply-section mt-3">
                            <div class="reply-title mb-2">Balasan:</div>
                            @foreach ($review->replies as $reply)
                                <div class="reply-item mb-3 pb-2 border-bottom" id="reply-{{ $reply->id }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <strong>{{ $reply->user ? $reply->user->name : 'Anonim ' . strtoupper(Str::random(5)) }}</strong>
                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="reply-comment mb-1">{{ $reply->comment }}</p>
                                    
                                    <div class="reply-actions">
                                        {{-- Fitur Love untuk Balasan --}}
                                        <button class="love-button" onclick="likeReply({{ $reply->id }})">
                                            ❤️ <span id="reply-love-count-{{ $reply->id }}">{{ $reply->likes_count }}</span>
                                        </button>

                                        {{-- Edit/Hapus untuk pemilik balasan --}}
                                        @auth
                                            @if(auth()->id() === $reply->user_id)
                                                <button class="btn btn-sm btn-outline-secondary ms-2 edit-reply" data-reply-id="{{ $reply->id }}">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                                <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" class="d-inline ms-2">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus balasan ini?')">
                                                        <i class="fas fa-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Form Balasan (Hidden by Default) --}}
                    @auth
                    <form action="{{ route('replies.store', $review->id) }}" method="POST" class="reply-form mt-3" id="reply-form-{{ $review->id }}" style="display: none;">
                        @csrf
                        <div class="mb-3">
                            <label for="reply-comment-{{ $review->id }}" class="form-label">Balas Ulasan</label>
                            <textarea name="comment" id="reply-comment-{{ $review->id }}" class="form-control" rows="3" placeholder="Tulis balasan Anda di sini..." required>{{ old('comment') }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                            <button type="button" class="btn btn-secondary cancel-reply" data-review-id="{{ $review->id }}">Batal</button>
                        </div>
                    </form>
                    @endauth
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada ulasan untuk toko ini.</p>
        @endif
    </div>
</div>

{{-- Form Ulasan --}}
@auth
<div class="card mb-5">
    <div class="card-header">
        <h5><i class="fas fa-edit me-2"></i>Tulis Ulasan Anda</h5>
    </div>
    <div class="card-body">
        {{-- Tampilkan error jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulir input ulasan --}}
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf

            {{-- Rating Interaktif --}}
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
                @error('rating')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Komentar --}}
            <div class="mb-3">
                <label for="comment" class="form-label">Komentar</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Tulis ulasan Anda di sini..." required>{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
    </div>
</div>
@else
<div class="card mb-5">
    <div class="card-body text-center">
        <div class="alert alert-warning mb-0">
            Silakan <a href="{{ route('login') }}" class="alert-link">login</a> untuk menulis ulasan.
        </div>
    </div>
</div>
@endauth

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Star Rating System
        const stars = document.querySelectorAll('.star-rating .fa-star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                ratingInput.value = value;

                // Reset semua bintang
                stars.forEach(s => s.classList.remove('selected'));

                // Warnai bintang sesuai rating
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }
            });

            // Hover effect
            star.addEventListener('mouseover', () => {
                const value = parseInt(star.getAttribute('data-value'));
                stars.forEach(s => s.classList.remove('hover'));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('hover');
                }
            });
        });

        // Reset hover when mouse leaves star rating
        document.querySelector('.star-rating').addEventListener('mouseleave', () => {
            stars.forEach(s => s.classList.remove('hover'));
        });

        // Initialize current rating
        const current = parseInt(ratingInput.value);
        if (current > 0) {
            for (let i = 0; i < current; i++) {
                stars[i].classList.add('selected');
            }
        }

        // Reply Toggle System
        document.querySelectorAll('.reply-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const reviewId = this.getAttribute('data-review-id');
                const form = document.getElementById(`reply-form-${reviewId}`);
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Cancel Reply
        document.querySelectorAll('.cancel-reply').forEach(button => {
            button.addEventListener('click', function() {
                const reviewId = this.getAttribute('data-review-id');
                const form = document.getElementById(`reply-form-${reviewId}`);
                form.style.display = 'none';
            });
        });
    });

    // Like Review Function
    function likeReview(reviewId) {
        fetch(`/reviews/${reviewId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeCount = document.getElementById(`love-count-${reviewId}`);
                likeCount.innerText = data.likes_count;
                
                // Optional: Add visual feedback
                const button = document.querySelector(`#review-${reviewId} .love-button`);
                button.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 200);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Like Reply Function
    function likeReply(replyId) {
        fetch(`/replies/${replyId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeCount = document.getElementById(`reply-love-count-${replyId}`);
                likeCount.innerText = data.likes_count;
                
                // Optional: Add visual feedback
                const button = document.querySelector(`#reply-${replyId} .love-button`);
                button.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 200);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Edit Review Function (Basic Implementation)
    document.querySelectorAll('.edit-review').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.getAttribute('data-review-id');
            const reviewItem = document.getElementById(`review-${reviewId}`);
            const comment = reviewItem.querySelector('.review-comment').textContent;
            
            // Replace with edit form (you can implement this as needed)
            const newContent = prompt('Edit ulasan Anda:', comment);
            if (newContent !== null) {
                // Here you would typically make an AJAX request to update the review
                console.log('Updating review:', reviewId, 'with content:', newContent);
                // For now, just update the display
                reviewItem.querySelector('.review-comment').textContent = newContent;
            }
        });
    });

    // Edit Reply Function (Basic Implementation)
    document.querySelectorAll('.edit-reply').forEach(button => {
        button.addEventListener('click', function() {
            const replyId = this.getAttribute('data-reply-id');
            const replyItem = document.getElementById(`reply-${replyId}`);
            const comment = replyItem.querySelector('.reply-comment').textContent;
            
            // Replace with edit form (you can implement this as needed)
            const newContent = prompt('Edit balasan Anda:', comment);
            if (newContent !== null) {
                // Here you would typically make an AJAX request to update the reply
                console.log('Updating reply:', replyId, 'with content:', newContent);
                // For now, just update the display
                replyItem.querySelector('.reply-comment').textContent = newContent;
            }
        });
    });
</script>
@endsection