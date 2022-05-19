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
    public function index(Request $request) 
    {
        if($request->number == null) {
            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->orderBy('products.name', 'ASC')->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } else {

            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->where('products.status', 2)->orderBy('products.name', 'ASC')->limit($request->number)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc', 'products.status']);
        }

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
        $product = ModelsProduct::select('products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc'  )->join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')->where('product_organizations.category', $category->id)->orWhere('products.status', 2)->get();

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
            $product = ModelsProduct::join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')-> where('product_organizations.exclusive', $id)->orWhere('products.status', 2)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } elseif ($id == "newItem") {
            $name = "newItem";
            $id = 2;
            $product = ModelsProduct::join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')-> where('product_organizations.exclusive', $id)->orWhere('products.status', 2)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } elseif ($id == "randomItem") {
            $name = "randomItem";
            $id = 0;
            $product = ModelsProduct::join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')->orWhere('products.status', 2)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } else {
            return response()->json(['success' => true, 'message' => 'Category data not found']);
        }

        $data = [
            "name" => $name,
            "data" => $product
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function searchProduct()
    {
        $search = $_GET['q'];
        $search_list = $_GET['list'];
        if($search_list == 'all') {
            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->where('name', 'like', '%' .$search. '%')->orWhere('products.status', 2)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } else {
            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->where('name', 'like', '%' .$search. '%')->orWhere('products.status', 2)->limit(10)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        }
        
        $data = [
            "data" => $product,
        ];
        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }
}
