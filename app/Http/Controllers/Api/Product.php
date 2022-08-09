<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product as ModelsProduct;
use App\Models\ProductBestSeller as ModelsBestSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
    //
    public function index(Request $request) 
    {
        if($request->number == null) {
            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->orderBy('products.name', 'ASC')->orWhere('products.status', 2)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
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
        $product = ModelsProduct::select('products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc'  )->join('product_organizations','products.sku', '=', 'product_organizations.sku')->join('product_media', 'products.sku', '=', 'product_media.sku')->where('product_organizations.category', $category->id)->where('products.status', 2)->get();

        $data = [
            "name" => $category->name,
            "img" => $category->img,
            "description" => $category->description,
            "data" => $product
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function exclusive($id)
    {
        if($id == "bestSeller") {
            $name = "bestSeller";
            $id = 1;
            $best_sellers = ModelsBestSeller::get();
            $product_best_sellers = [];
	        $value_products = [];
            $product_value = [];
            foreach($best_sellers as $key => $best_seller) {
                $product_best_sellers[$key] = DB::table('products')
                    ->select('products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc')
                    ->where('products.sku', $best_seller->prd_id)
                    ->where('products.status','=',2)
                    ->join('product_media', 'products.sku','product_media.sku')
                    ->get();
            }
            foreach($product_best_sellers as $key => $product_best_seller) {
                if(count($product_best_seller) == 0) {
                unset($product_best_sellers[$key]);
                }	
            }
            foreach($product_best_sellers as $key => $product_best_seller) {
                $value_products[$key] = $product_best_seller;
                $product_value[$key] = $value_products[$key][0];
            }
            $product = array_values($product_value);
            // $product = ModelsProduct::join('product_organizations','products.sku','=','product_organizations.sku')
            //                     ->join('product_media','products.sku','=','product_media.sku')
            //                     ->where('product_organizations.exclusive','=',$id)
            //                     ->where('products.status','=',2)
            //                     ->orderBy('products.created_at','DESC')
            //                     ->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } elseif ($id == "newItem") {
            $name = "newItem";
            $id = 2;
            $product = ModelsProduct::join('product_organizations','products.sku','=','product_organizations.sku')
                                ->join('product_media','products.sku','=','product_media.sku')
                                ->where('product_organizations.exclusive','=',$id)
                                ->where('products.status','=',2)
                                ->orderBy('products.created_at','DESC')
                                ->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } elseif ($id == "randomItem") {
            $name = "randomItem";
            $id = 0;
            $product = ModelsProduct::join('product_organizations','products.sku','=','product_organizations.sku')
                                ->join('product_media','products.sku','=','product_media.sku')
                                ->where('product_organizations.exclusive','=',$id)
                                ->where('products.status','=',2)
                                ->orderBy('products.created_at','DESC')
                                ->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } else {
            $name = "testItem";
            $datas = DB::connection('oracle')->select('select prd_id,prd_nm from (SELECT m.prd_id, m.prd_nm,sum(d.ord_cost) as disp_seq from prd_prd_m m inner join ord_ord_dtl_d d on m.prd_id = d.prd_id and m.prd_ptr_cd = :a inner join ord_ord_sts_chg_h h on d.ord_id = h.ord_id and d.ord_ptr_cd in (:b) and d.ord_seq = h.ord_seq and d.ord_sts_cd = :c and h.ord_dtl_sts_cd = :d and m.prd_nm not like :e and h.ord_sts_dtm between to_date(to_char(sysdate - 7, :f), :f) and to_date(to_char(sysdate - 1, :f), :f) + 0.99999 group by m.prd_id,m.prd_nm) order by disp_seq desc',['a' => '10', 'b' => '100', 'c' => '70', 'd' => '7010', 'e' => '%NC%', 'f' => 'YYYY-MM-DD']);
            $product = [];
	        $test = [];
            foreach($datas as $key => $data) {
                $product[$key] = DB::table('products')
                    ->select('products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc')
                    ->where('products.sku', $data->prd_id)
                    ->where('products.status','=',2)
                    ->join('product_media', 'products.sku','product_media.sku')
                    ->get();
            }
            foreach($product as $key => $products) {
                    if(count($products) == 0) {
                    unset($product[$key]);
                    }	
            }
            foreach($product as $key => $products) {
                $test[$key] = $products;
                $tost[$key] = $test[$key][0];
            }
            $total = count($product);

            $data = [
                "name" => $name,
                "total" => $total,
                "data" => array_values($tost)
            ];
            
            return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
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
            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->where('products.status', 2)->where('name', 'like', '%' .$search. '%')->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        } else {
            $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->where('products.status', 2)->where('name', 'like', '%' .$search. '%')->limit(10)->get(['products.id', 'products.slug', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc']);
        }
        
        $data = [
            "data" => $product,
        ];
        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function updateActiveProduct($id)
    {
        DB::table('products')->where('slug', $id)->update([
            'status' => $_GET['status'],
        ]);

        $data = [
            "message" => "Product has been edit successfully"
        ];
        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function countEcommerceProduct($id)
    {
        $checkCount = DB::table('product_view')->where('slug', $id)->first();
        $eco = $_GET['eco'];

        if($checkCount == null) {
            if($eco == 'aladin_mall') {
                DB::table('product_view')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '1', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '1', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'tokopedia') {
                DB::table('product_view')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '1', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '1', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'shopee') {
                DB::table('product_view')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '1', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '1', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'lazada') {
                DB::table('product_view')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '1', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]); 
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '1', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'blibli') {
                DB::table('product_view')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '1', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '1', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                DB::table('product_view')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        } else {
            DB::table('product_view')->where('slug', $id)->update([
                $_GET['eco'] => $checkCount->$eco + 1,
                'updated_at' => Carbon::now(),
            ]);
            if($eco == 'aladin_mall') {
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '1', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'tokopedia') {
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '1', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'shopee') {
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '1', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif($eco == 'lazada') {
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '1', 
                    'blibli' => '0', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]); 
            } elseif($eco == 'blibli') {
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '1', 
                    'bukalapak' => '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                DB::table('product_click')->insert([
                    'slug' => $id, 
                    'aladin_mall' => '0', 
                    'tokopedia' => '0', 
                    'shopee' => '0', 
                    'lazada' => '0', 
                    'blibli' => '0', 
                    'bukalapak' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        
        $data = [
            "message" => "Product has been successfully",
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }

    public function viewEcommerceProduct($id)
    {
        $count = [];
        if($id == 'all-product') {
            $checkCount = DB::table('product_view')->get();
            foreach($checkCount as $key => $viewCount) {
                $count_aladin[$key] = $checkCount[$key]->aladin_mall;
                $count_tokopedia[$key] = $checkCount[$key]->tokopedia;
                $count_shopee[$key] = $checkCount[$key]->shopee;
                $count_lazada[$key] = $checkCount[$key]->lazada;
                $count_blibli[$key] = $checkCount[$key]->blibli;
                $count_bukalapak[$key] = $checkCount[$key]->bukalapak;
            }
            $count = array('aladin_mall' => array_sum($count_aladin), 'tokopedia' => array_sum($count_aladin), 'tokopedia' => array_sum($count_tokopedia), 'shopee' => array_sum($count_shopee), 'lazada' => array_sum($count_lazada), 'blibli' => array_sum($count_blibli), 'bukalapak' => array_sum($count_bukalapak));
        } else {
            $count = DB::table('product_view')->select('aladin_mall', 'tokopedia', 'shopee', 'lazada', 'blibli', 'bukalapak')->where('slug', $id)->first();
        }
        $data = [
            "data" => $count,
        ];

        return response()->json(['success' => true, 'message' => 'Data found', 'data' => $data]);
    }
}
