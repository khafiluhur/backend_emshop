<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product as ModelsProduct;
use App\Models\ProductLink;
use App\Models\ProductMedia;
use App\Models\ProductOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
Use \Carbon\Carbon;

class Product extends Controller
{
    //
    public function index() {

        $items = [];
        $products = DB::table('products')
                   ->select('product_media.id', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc', 'products.status', 'products.sku', 'products.slug', 'products.created_at', 'products.updated_at', 'product_view.aladin_mall', 'product_view.tokopedia', 'product_view.shopee', 'product_view.lazada', 'product_view.blibli', 'product_view.bukalapak')
                   ->join('product_media', 'products.sku', '=', 'product_media.sku')
                   ->leftJoin('product_view', 'products.slug', '=', 'product_view.slug')
                   ->orderBy('products.created_at', 'DESC')
                   ->get();

        foreach($products as $key => $product) {
            $items[$key] = array(
                "img" => $products[$key]->img,
                "name" => $products[$key]->name,
                "price" => $products[$key]->price,
                "disc_price" => $products[$key]->disc_price,
                "disc" => $products[$key]->disc,
                "status" => $products[$key]->status,
                "sku" => $products[$key]->sku,
                "slug" => $products[$key]->slug,
                "id" => $products[$key]->id,
                "aladin_mall" => $products[$key]->aladin_mall,
                "tokopedia" => $products[$key]->tokopedia,
                "shopee" => $products[$key]->shopee,
                "lazada" => $products[$key]->lazada,
                "blibli" => $products[$key]->blibli,
                "bukalapak" => $products[$key]->bukalapak,
                "total_view" => $products[$key]->aladin_mall + $products[$key]->tokopedia + $products[$key]->shopee + $products[$key]->lazada + $products[$key]->blibli + $products[$key]->bukalapak,
                "created_at" => $products[$key]->created_at,
                "updated_at" => $products[$key]->updated_at,
            );
        }

        $data = [
            'title' => 'Daftar Produk',
            'slug' => 'product',
            'category' => Category::orderBy('created_at', 'DESC')->get(),
            'product' => $items
        ];

        return view('pages.admin.table.index', $data);
    }

    public function create() {
        $generate_code = rand(0,99999);

        $data = [
            'title' => 'Tambah Produk',
            'slug' => 'product',
            'category' => Category::orderBy('name', 'ASC')->get(),
            'brand' => Brand::orderBy('name', 'ASC')->get(),
            'code' => $generate_code
        ];
        return view('pages.admin.table.create', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:products',
            'short_desc' => 'required',
            'price' => 'required',
            'disc_price' => 'required',
            'disc' => 'required',
            'img' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'exclusive' => 'required',
        ],[
          'name.required' => 'Nama produk harus diisi',  
          'sku.required' => 'SKU produk harus diisi', 
          'short_desc.required' => 'Deskripsi produk harus diisi',
          'price.required' => 'Harga produk harus diisi',
          'disc_price.required' => 'Harga diskon produk harus diisi',
          'disc.required' => 'Diskon produk harus diisi',
          'img.required' => 'Gambar produk harus diisi',
          'brand.required' => 'Brand produk harus '
        ]);

        $product = ModelsProduct::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'slug' => Str::slug($request->name),
            'short_desc' => $request->short_desc,
            'price' => $request->price,
            'disc_price' => $request->disc_price,
            'disc' => $request->disc,
            'status' => 2,
            'created_at' => Carbon::now()
        ]);

        if($request->aladin_mall == null) {
            $aladin_mall = 'aladin';
        } else {
            $aladin_mall = $request->aladin_mall;
        }

        if($request->tokopedia == null) {
            $tokopedia = 'tokopedia';
        } else {
            $tokopedia = $request->tokopedia;
        }

        if($request->shopee == null) {
            $shopee = 'shopee';
        } else {
            $shopee = $request->shopee;
        }

        if($request->lazada == null) {
            $lazada = 'lazada';
        } else {
            $lazada = $request->lazada;
        }

        if($request->blibli == null) {
            $blibli = 'blibli';
        } else {
            $blibli = $request->blibli;
        }

        if($request->bukalapak == null) {
            $bukalapak = 'bukalapak';
        } else {
            $bukalapak = $request->bukalapak;
        }

        $product_link = ProductLink::create([
            'sku' => $request->sku,
            'aladin_mall' => $aladin_mall,
            'tokopedia' => $tokopedia,
            'shopee' => $shopee,
            'lazada' => $lazada,
            'blibli' => $blibli,
            'bukalapak' => $bukalapak,
            'created_at' => Carbon::now()
        ]);

        $img_product = Str::slug($request->name).'.'.$request->file('img')->extension();
        $request->file('img')->move('assets/imgs/products', $img_product);

        $product_media = ProductMedia::create([
            'sku' => $request->sku,
            'img' => $img_product,
            'created_at' => Carbon::now()
        ]);

        $product_organization = ProductOrganization::create([
            'sku' => $request->sku,
            'brand' => $request->brand,
            'category' => $request->category,
            'exclusive' => $request->exclusive,
            'created_at' => Carbon::now()
        ]);

        if ($product && $product_link && $product_media && $product_organization) {
            return redirect()
            ->route('product.index')
            ->with([
                'success' => 'New category has been created successfully'
            ]);
        } else {
            return redirect()
            ->route('product.create')
            ->with([
                'error' => 'Some problem occurred, please try again'
            ]);
        }
    }

    public function edit($id) 
    {
        $product = DB::table('products')
                   ->join('product_media', 'products.sku', '=', 'product_media.sku')
                   ->join('product_links', 'products.sku', '=', 'product_links.sku')
                   ->join('product_organizations', 'products.sku', '=', 'product_organizations.sku')
                   ->where('products.slug',$id)
                   ->first();

        $data = [
            'title' => 'Ubah Produk',
            'slug' => 'product',
            'product' => $product,
            'category' => Category::orderBy('name', 'ASC')->get(),
            'brand' => Brand::orderBy('name', 'ASC')->get()
        ];
        return view('pages.admin.table.edit', $data);
    }

    public function update(Request $request, $id) 
    {
        $products = DB::table('products')
                ->select('*')
                ->where('products.slug', $id)
                ->first();

        $sku = $products->sku;
        
        DB::table('products')->where('id', $products->id)->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'slug' => Str::slug($request->name),
            'short_desc' => $request->short_desc,
            'price' => $request->price,
            'disc_price' => $request->disc_price,
            'disc' => $request->disc,
            'updated_at' => Carbon::now()
        ]);

        $product_links = DB::table('product_links')
                ->select('*')
                ->where('product_links.sku', $sku)
                ->first();

        DB::table('product_links')->where('id', $product_links->id)->update([
            'sku' => $request->sku,
            'aladin_mall' => $request->aladin_mall,
            'tokopedia' => $request->tokopedia,
            'shopee' => $request->shopee,
            'lazada' => $request->lazada,
            'blibli' => $request->blibli,
            'bukalapak' => $request->bukalapak,
            'updated_at' => Carbon::now()
        ]);

        $product_medias = DB::table('product_media')
                ->select('*')
                ->where('product_media.sku', $sku)
                ->first();
        
        DB::table('product_media')->where('id', $product_medias->id)->update([
            'sku' => $request->sku,
        ]);

        if($request->file('img') != null) {
            $img_product = Str::slug($request->name).'.'.$request->file('img')->extension();
            $request->file('img')->move('assets/imgs/products', $img_product);

            DB::table('product_media')->where('id', $product_medias->id)->update([
                'img' => $img_product,
            ]);
        }

        $product_organizations = DB::table('product_organizations')
                ->select('*')
                ->where('product_organizations.sku', $sku)
                ->first();
    

        DB::table('product_organizations')->where('id', $product_organizations->id)->update([
            'sku' => $request->sku,
            'brand' => $request->brand,
            'category' => $request->category,
            'exclusive' => $request->exclusive,
            'updated_at' => Carbon::now()
        ]);

        return redirect()
        ->route('product.index')
        ->with([
            'success' => 'Product has been edit successfully'
        ]);

    }

    public function delete($id) {
        $product = DB::table('products')
                    ->where('slug', $id)
                    ->first();
        DB::table('product_links')
                    ->where('sku', $product->sku)
                    ->delete();
        DB::table('product_media')
                    ->where('sku', $product->sku)
                    ->delete();
        DB::table('product_organizations')
                    ->where('sku', $product->sku)
                    ->delete();
        DB::table('products')
                    ->where('slug', $id)
                    ->delete();

        return redirect()
            ->route('product.index')
            ->with([
                'success' => 'Product has been created successfully delete'
            ]);
    }

    public function oracle() {
        $datas = DB::connection('oracle')->select('select prd_id,prd_nm from (SELECT m.prd_id, m.prd_nm,sum(d.ord_cost) as disp_seq from prd_prd_m m inner join ord_ord_dtl_d d on m.prd_id = d.prd_id and m.prd_ptr_cd = :a inner join ord_ord_sts_chg_h h on d.ord_id = h.ord_id and d.ord_ptr_cd in (:b) and d.ord_seq = h.ord_seq and d.ord_sts_cd = :c and h.ord_dtl_sts_cd = :d and m.prd_nm not like :e and h.ord_sts_dtm between to_date(to_char(sysdate - 7, :f), :f) and to_date(to_char(sysdate - 1, :f), :f) + 0.99999 group by m.prd_id,m.prd_nm) order by disp_seq desc',['a' => '10', 'b' => '100', 'c' => '70', 'd' => '7010', 'e' => '%NC%', 'f' => 'YYYY-MM-DD']);
        $item = [];
	$test = [];
        foreach($datas as $key => $data) {
            //  $item[$key] = $data->prd_id;
	   $item[$key] = DB::table('products')->select('*')->where('products.sku', $data->prd_id)->get();
	   // $result = array_filter($item[$key], function ($value) {
           //	return !is_null($value);
    	   // });

	   //if (count($result) == 0) {
           // 	unset($data[$index]);
    	   // }
	
	   // $item[$key] = DB::table('products')->select('*')->where('products.sku', $data->prd_id)->get();
	   // if($item[$key] == null) {
	   //	$test[$key] = "tost"
	   // } else {
	   //	$
	   // }
        }
	$test = [];
	foreach($item as $key => $items) {
	  // $test = $item;
	  // $result = array_filter($items, function($value) {
	  //	retrun is_null($value);
	  // });
	
	  if(count($items) == 0) {
	  	unset($item[$key]);
	  }
	}
	foreach($item as $key => $items) {
	     $test[$key] = $items[$key];
	}
       //  dd(array_slice($item, 0, 5));
        dd(array_values($test));
    }
}
