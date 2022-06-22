<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModelsCategory;
use App\Models\Category;
use App\Models\Product as ModelsProduct;
use App\Models\ProductLink;
use App\Models\ProductMedia;
use App\Models\ProductOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
Use \Carbon\Carbon;

class Report extends Controller
{

    public function index() {
        $items = DB::table('products')
            ->select('product_media.id', 'product_media.img', 'products.name', 'products.price', 'products.disc_price', 'products.disc', 'products.status', 'products.sku', 'products.slug', 'products.created_at', 'products.updated_at', 'product_view.aladin_mall', 'product_view.tokopedia', 'product_view.shopee', 'product_view.lazada', 'product_view.blibli', 'product_view.bukalapak' )
            ->join('product_media', 'products.sku', '=', 'product_media.sku')
            ->leftJoin('product_view', 'products.slug', '=', 'product_view.slug')
            ->orderBy('products.created_at', 'DESC')
            ->get();

        $data = [
            'title' => 'Report',
            'slug' => 'report',
            'items' => $items
        ];
        return view('pages.admin.report.index', $data);
    }

}

?>