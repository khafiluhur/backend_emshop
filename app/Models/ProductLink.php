<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku','aladin_mall','tokopedia','shopee','lazada','blibli','bukalapak'
    ];
}
