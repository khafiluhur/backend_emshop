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
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Controller
{
    //
    public function index() {

        $product = ModelsProduct::join('product_media', 'products.sku', '=', 'product_media.sku')->orderBy('products.name', 'ASC')->get(['products.*', 'product_media.img']);

        $data = [
            'title' => 'Product List',
            'slug' => 'product',
            'category' => Category::orderBy('name', 'ASC')->get(),
            'product' => $product
        ];
        return view('pages.admin.table.index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Add New Product',
            'slug' => 'product',
            'category' => Category::orderBy('name', 'ASC')->get(),
            'brand' => Brand::orderBy('name', 'ASC')->get()
        ];
        return view('pages.admin.table.create', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'sku' => 'required',
            'short_desc' => 'required',
            'price' => 'required',
            'disc_price' => 'required',
            'disc' => 'required',
            'img' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'exclusive' => 'required'
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
        ]);

        $img_product = Str::slug($request->name).'.'.$request->file('img')->extension();
        $request->file('img')->move(env('APP_ASSET').'/assets/imgs/products', $img_product);

        $product_media = ProductMedia::create([
            'sku' => $request->sku,
            'img' => $img_product,
        ]);

        $product_organization = ProductOrganization::create([
            'sku' => $request->sku,
            'brand' => $request->brand,
            'category' => $request->category,
            'exclusive' => $request->exclusive
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

    public function edit($id) {

        $product = DB::table('products')
                   ->join('product_organizations', 'products.sku', '=', 'product_organizations.sku')
                   ->join('product_media', 'products.sku', '=', 'product_media.sku')
                   ->join('product_links', 'products.sku', '=', 'product_links.sku')
                   ->where('products.name',$id)
                   ->first();
                   
        $data = [
            'title' => 'Edit Product',
            'slug' => 'product',
            'product' => $product,
            'category' => Category::orderBy('name', 'ASC')->get(),
            'brand' => Brand::orderBy('name', 'ASC')->get()
        ];
        return view('pages.admin.table.edit', $data);
    }

    public function update(Request $request, $id) {
        // $product =  DB::table('products')->where('products.sku',$id)->first();
        // $product_link = DB::table('product_links')->where('product_links.sku',$id)->first();
        // $product_media = DB::table('product_media')->where('product_media.sku',$id)->first();
        // $product_organizations = DB::table('product_organizations')->where('product_organizations.sku',$id)->first();

        // DB::table('products')->where('products.sku', $id)->update([
        //     'name' => $request->name,
        //     'sku' => $request->sku,
        //     'slug' => Str::slug($request->name),
        //     'short_desc' => $request->short_desc,
        //     'price' => $request->price,
        //     'disc_price' => $request->disc_price,
        //     'disc' => $request->disc,
        //     'status' => $request->status,
        // ])
        // $product = ;
        // dd($product);
    }

    public function delete(Request $request, $id) {
        $product =  ModelsProduct::findOrFail($id);
        $product_link = ProductLink::findOrFail($id);
        $product_media = ProductMedia::findOrFail($id);
        $product_organization = ProductOrganization::findOrFail($id);
    }
}
