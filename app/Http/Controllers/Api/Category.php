<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;

class Category extends Controller
{
    //
    public function index() {

        $product = ModelsCategory::get();

        $data = $product;

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }
}
