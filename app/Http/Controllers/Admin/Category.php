<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Category extends Controller
{
    //
    public function index() {
        $data = [
            'title' => 'Category List',
            'slug' => 'category',
            'category' => ModelsCategory::orderBy('name', 'ASC')->get(),
        ];
        return view('pages.admin.category.index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Add New Category',
        ];
        return view('pages.admin.table.create', $data);
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'icon' => 'required',
            'img' => 'required',
        ]);
        
        $iconCategory = Str::slug($request->name).'.'.$request->icon->extension();
        $bannerCategory = 'banner-'.Str::slug($request->name).'.'.$request->img->extension();
        $request->icon->move(public_path('assets/imgs/category'), $iconCategory);
        $request->img->move(public_path('assets/imgs/category'), $bannerCategory);

        $post = ModelsCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $iconCategory,
            'img' => $bannerCategory
        ]);

        if ($post) {
            return redirect()
            ->route('category.index')
            ->with([
                'success' => 'New category has been created successfully'
            ]);
        } else {
            return redirect()
            ->route('category.index')
            ->with([
                'error' => 'Some problem occurred, please try again'
            ]);
        }
    
    }
}
