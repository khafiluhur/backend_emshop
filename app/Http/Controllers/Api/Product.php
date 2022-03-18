<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product as ModelsProduct;
use App\Models\ProductLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
    //
    public function index() {

        $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->orderBy('products.name', 'ASC')->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);

        $data = $product;

        return response()->json(['data' => $data]);
    }

    public function detail($id) {

        // $product = DB::table('products')
        //            ->join('product_organizations', 'products.sku', '=', 'product_organizations.sku')
        //            ->join('product_media', 'products.sku', '=', 'product_media.sku')
        //            ->join('product_links', 'products.sku', '=', 'product_links.sku')
        //            ->where('products.slug',$id)
        //            ->first();
        $product = ModelsProduct::where('slug', $id)->first();
        $links = ProductLink::where('sku', $product->sku)->first();

        $data = [
            $product,
            [$links],
            
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function category($id) {
       
        $category = Category::where('slug', $id)->first();
        $product = ModelsProduct::join('product_organizations','products.sku', '=', 'product_organizations.sku')-> where('product_organizations.category', $category->id)->get();

        $data = [
            $product
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function exclusive($id) {

        $product = ModelsProduct::join('product_organizations','products.sku', '=', 'product_organizations.sku')-> where('product_organizations.exclusive', $id)->get();

        $data = [
            $product
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }
}
