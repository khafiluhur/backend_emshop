<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrganization extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku','brand','category','exclusive'
    ];
}
