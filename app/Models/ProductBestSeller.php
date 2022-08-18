<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBestSeller extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 'name'
    ];
}
