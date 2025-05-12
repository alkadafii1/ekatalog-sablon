<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportingImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path'];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
