<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
Use \Carbon\Carbon;

class Category extends Controller
{
    //
    public function index() {
        $data = [
            'title' => 'Daftar Kategori',
            'slug' => 'category',
            'category' => ModelsCategory::orderBy('name', 'ASC')->get(),
        ];
        return view('pages.admin.category.index', $data);
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
            'img' => $bannerCategory,
            'description' => $request->description,
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

    public function create() {
        $data = [
            'title' => 'Tambah Kategori',
            'type' => 'add',
        ];
        return view('pages.admin.category.form', $data);
    }

    public function edit($id) {
        $data = [
            'title' => 'Ubah Kategori',
            'type' => 'edit',
            'category' => ModelsCategory::where('id', $id)->first(),
        ];
        return view('pages.admin.category.form', $data);
    }

    public function update(Request $request, $id) {

        if($request->file('icon') != null) {
            $iconCategory = Str::slug($request->name).'.'.$request->icon->extension();
            $request->icon->move(public_path('assets/imgs/category'), $iconCategory);
            DB::table('categories')->where('id', $id)->update([
                'icon' => $iconCategory,
                'updated_at' => Carbon::now()
            ]);
        }

        if($request->file('img') != null) {
            $bannerCategory = 'banner-'.Str::slug($request->name).'.'.$request->img->extension();
            $request->img->move(public_path('assets/imgs/category'), $bannerCategory);
            DB::table('categories')->where('id', $id)->update([
                'img' => $bannerCategory,
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);

        return redirect()
        ->route('category.index')
        ->with([
            'success' => 'Category has been edit successfully'
        ]);
    }

    public function delete($id) {
        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('category.index')->with(['success' => 'Category has been created successfully delete']);
    }
}
