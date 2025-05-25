<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Wishlist extends Pivot
{
    protected $table = 'wishlist';
}