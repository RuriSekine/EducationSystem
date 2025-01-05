<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Curriculum;
use Illuminate\Http\Request;


class Curriculum_listController extends Controller
{
    public function index () {
        return view('user.curriculum_list');
    }
}
