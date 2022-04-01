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
    public function index() 
    {
         $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->orderBy('products.name', 'ASC')->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);

        $data = $product;

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);   
    }

    public function detail($id) 
    {
        $product = DB::table('products')
                    ->join('product_organizations', 'products.sku', '=', 'product_organizations.sku')
                    ->join('product_media', 'products.sku', '=', 'product_media.sku')
                    ->join('product_links', 'products.sku', '=', 'product_links.sku')
                    ->join('categories', 'product_organizations.category', '=', 'categories.id')
                    ->where('products.slug',$id)
                    ->first(['products.name', 'products.slug', 'product_media.img', 'products.sku', 'products.name', 'products.price', 'products.disc_price', 'categories.name as category', 'categories.slug as slug_category', 'products.disc', 'products.short_desc', 'product_links.aladin_mall', 'product_links.tokopedia', 'product_links.shopee', 'product_links.lazada', 'product_links.blibli', 'product_links.bukalapak']);

        $data = [
            "name" => $product->name,
            "img" => $product->img,
            "sku" => $product->sku,
            "slug" => $product->slug,
            "short_desc" => $product->short_desc,
            "price" => $product->price,
            "disc_price" => $product->disc_price,
            "disc" => $product->disc,
            "category" => $product->category,
            'slug_category' => $product->slug_category,
            "link" => [
                "aladin" => $product->aladin_mall,
                "tokopedia" => $product->tokopedia,
                "shopee" => $product->shopee,
                "lazada" => $product->lazada,
                "blibli" => $product->blibli,
                "bukalapak" => $product->bukalapak
            ],
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function category($id) 
    {
        $category = Category::where('slug', $id)->first();
        $product = ModelsProduct::select('products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc'  )->join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')-> where('product_organizations.category', $category->id)->get();

        $data = [
            "name" => $category->name,
            "img" => $category->img,
            "data" => $product
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function exclusive($id)
    {
        if($id == "bestSeller") {
            $name = "bestSeller";
            $id = 1;
        } elseif ($id == "newItem") {
            $name = "newItem";
            $id = 2;
        } elseif ($id == "randomItem") {
            $name = "randomItem";
            $id = 0;
        } else {
            return response()->json(['success' => true, 'message' => 'Category data not found']);
        }
        
        $product = ModelsProduct::join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')-> where('product_organizations.exclusive', $id)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);

        $data = [
            "name" => $name,
            "data" => $product
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }
}
