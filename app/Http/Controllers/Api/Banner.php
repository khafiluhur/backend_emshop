<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner as ModelsBanner;
use Illuminate\Http\Request;

class Banner extends Controller
{
    //
    public function index() {

        $product = ModelsBanner::get();

        $product;

        return response()->json(['data' => $product]);
    }
}
