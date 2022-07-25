<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
    //
    public function index() {
        $data = [
            'title' => 'Dashboard',
            'slug' => 'dashboard',
        ];
        // dd(Auth::user());
        
        return view('pages.admin.index', $data);
    }

    public function edit() {
        $data = [
            'title' => 'Dashboard',
            'slug' => 'dashboard',
        ];
        return view('pages.admin.edit', $data);
    }

    public function phpinfo() {
        return view('pages.phpinfo');
    }
}
