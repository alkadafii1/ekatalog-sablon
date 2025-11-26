<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{ 
    use HasFactory;

    protected $fillable = ['name', 'description', 'main_image', 'availability', 'category_id', 'price'];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke Wishlist
    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlist')
            ->withTimestamps();
    }
    
}