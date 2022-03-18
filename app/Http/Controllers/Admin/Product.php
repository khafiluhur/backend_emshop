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
            'full_desc' => 'required',
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
            'full_desc' => $request->full_desc,
            'price' => $request->price,
            'disc_price' => $request->disc_price,
            'disc' => $request->disc,
            'status' => 2,
        ]);

        $product_link = ProductLink::create([
            'sku' => $request->sku,
            'aladin_mall' => $request->aladin_mall,
            'tokopedia' => $request->tokopedia,
            'shopee' => $request->shopee,
            'lazada' => $request->lazada,
            'blibli' => $request->blibli,
            'bukalapak' => $request->bukalapak,
        ]);

        $img_product = Str::slug($request->name).'.'.$request->file('img')->extension();
        $request->file('img')->move(public_path('assets/imgs/products'), $img_product);

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
                   ->where('products.id',$id)
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
}
