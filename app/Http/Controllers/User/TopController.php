<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class TopController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view("user.top",compact("articles"));
    }
}
