<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug','aladin_mall','tokopedia','shopee','lazada','blibli','bukalapak'
    ];
}
