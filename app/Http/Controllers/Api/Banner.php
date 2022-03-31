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

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $product]);
    }
}
