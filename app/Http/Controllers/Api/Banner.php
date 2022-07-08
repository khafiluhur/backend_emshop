<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner as ModelsBanner;
use Illuminate\Support\Facades\DB;

class Banner extends Controller
{
    //
    public function index() {

        $product = ModelsBanner::where('status', 2)->orderBy('created_at','DESC')->get();

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $product]);
    }

    public function updateActiveBanner($id)
    {
        DB::table('banners')->where('slug', $id)->update([
            'status' => $_GET['status'],
        ]);

        $data = [
            "message" => "Product has been edit successfully"
        ];
        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }
}
