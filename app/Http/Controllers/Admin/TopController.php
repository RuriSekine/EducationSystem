<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth; 

class TopController extends Controller
{
    public function showTop() {

        $admin = Auth::guard('admin')->user();
        // ログイン者の情報のみ

        return view('admin.top', ['admin' => $admin]);
    }
    
}
