<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
