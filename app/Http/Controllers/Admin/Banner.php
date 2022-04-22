<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner as ModelsBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Banner extends Controller
{
    //
    public function index() {
        $data = [
            'title' => 'Banner List',
            'slug' => 'banner',
            'banner' => ModelsBanner::latest()->limit(10)->get()
        ];
        return view('pages.admin.table.index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Add New Banner',
            'slug' => 'banner',
        ];
        return view('pages.admin.table.create', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'link' => 'required',
            'img' => 'required',
        ]);

        $banner = 'banner-'.Str::slug($request->title).'.'.$request->img->extension();
        $request->img->move(public_path('assets/imgs/banners'), $banner);

        $post = ModelsBanner::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'link' => $request->link,
            'img' => $banner,
            'status' => 2
        ]);

        if ($post) {
            return redirect()
            ->route('banner.index')
            ->with([
                'success' => 'New banner has been created successfully'
            ]);
        } else {
            return redirect()
            ->route('banner.create')
            ->with([
                'error' => 'Some problem occurred, please try again'
            ]);
        }
    }
}
