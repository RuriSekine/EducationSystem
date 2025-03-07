<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CurriculumProgress;
use Illuminate\Http\Request;


class ProgressController extends Controller
{
    public function index () {
        return view('user.curriculum_progress');
    }
}
