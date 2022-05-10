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

        $product = DB::table('products')
                   ->join('product_media', 'products.sku', '=', 'product_media.sku')
                   ->select('product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc', 'products.status', 'products.sku', 'products.slug', 'products.created_at' )
                   ->orderBy('products.created_at', 'DESC')
                   ->paginate(15);
        // $product = DB::select('select * FROM product')->paginate(15);
        // join('product_media', 'products.sku', '=', 'product_media.sku')->orderBy('products.name', 'ASC')->get(['products.*', 'product_media.img'])
        // dd($product);
        $data = [
            'title' => 'Daftar Produk',
            'slug' => 'product',
            'category' => Category::orderBy('created_at', 'DESC')->get(),
            'product' => $product
            // Storage::directories(directory);
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

        // foreach( $request->file('img') )
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

    public function edit($id) {

        $product = DB::table('products')
                   ->join('product_organizations', 'products.sku', '=', 'product_organizations.sku')
                   ->join('product_media', 'products.sku', '=', 'product_media.sku')
                   ->join('product_links', 'products.sku', '=', 'product_links.sku')
                   ->where('products.slug',$id)
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

        $product = DB::table('products')->where('sku', $id)->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'slug' => Str::slug($request->name),
            'short_desc' => $request->short_desc,
            'price' => $request->price,
            'disc_price' => $request->disc_price,
            'disc' => $request->disc,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ]);

        $product_link = DB::table('product_links')->where('sku', $id)->update([
            'aladin_mall' => $request->aladin_mall,
            'tokopedia' => $request->tokopedia,
            'shopee' => $request->shopee,
            'lazada' => $request->lazada,
            'blibli' => $request->blibli,
            'bukalapak' => $request->bukalapak,
            'updated_at' => Carbon::now()
        ]);

        $img_product = Str::slug($request->name).'.'.$request->file('img')->extension();
        $request->file('img')->move('/assets/imgs/products', $img_product);

        $product_media = ProductMedia::create([
            'sku' => $request->sku,
            'img' => $img_product,
            'created_at' => Carbon::now()
        ]);

        $product_organization = DB::table('product_organizations')->where('sku', $id)->update([
            'brand' => $request->brand,
            'category' => $request->category,
            'exclusive' => $request->exclusive,
            'updated_at' => Carbon::now()
        ]);

        if ($product && $product_link && $product_media && $product_organization) {
            return redirect()
            ->route('product.index')
            ->with([
                'success' => 'New product has been created successfully'
            ]);
        } else {
            return redirect()
            ->route('product.create')
            ->with([
                'error' => 'Some problem occurred, please try again'
            ]);
        }

    }

    public function delete($id) {
        $product = DB::table('products')
                   ->where('products.slug',$id)
                   ->delete();
        $product_link = DB::table('product_links')
                   ->where('products.slug',$id)
                   ->delete();
        $product =  ModelsProduct::findOrFail($id);
        $product_link = ProductLink::findOrFail($id);
        $product_media = ProductMedia::findOrFail($id);
        $product_organization = ProductOrganization::findOrFail($id);
        $product->delete();
        $product_link->delete();
        $product_media->delete();
        $product_organization->delete();

        return redirect()
            ->route('product.index')
            ->with([
                'success' => 'Product has been created successfully delete'
            ]);
    }
}
