<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    use HasFactory;

    protected $fillable = ['name', 'description', 'main_image', 'availability'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke SupportingImage
    public function supportingImages()
    {
        return $this->hasMany(SupportingImage::class);
    }
}