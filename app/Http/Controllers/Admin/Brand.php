<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand as ModelsBrand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Brand extends Controller
{
    //
    public function index() {

        $data = [
            'title' => 'Daftar Merek',
            'slug' => 'brand',
            'category' => Category::orderBy('name', 'ASC')->get(),
            'brand' => ModelsBrand::orderBy('name', 'ASC')->get(['brands.name', 'brands.img', 'brands.slug'])
        ];
        return view('pages.admin.brand.index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Merek',
            'slug' => 'brand',
            'category' => Category::orderBy('name', 'ASC')->get(),
        ];
        return view('pages.admin.brand.create', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'img' => 'required',
            'category' => 'required',
        ]);

        $brand = 'banner-'.Str::slug($request->name).'.'.$request->file('img')->extension();
        $request->file('img')->move(public_path('assets/imgs/brands'), $brand);

        $post = ModelsBrand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'img' => $brand
        ]);

        if ($post) {
            return redirect()
            ->route('brand.index')
            ->with([
                'success' => 'New brand has been created successfully'
            ]);
        } else {
            return redirect()
            ->route('brand.create')
            ->with([
                'error' => 'Some problem occurred, please try again'
            ]);
        }
    }
}
