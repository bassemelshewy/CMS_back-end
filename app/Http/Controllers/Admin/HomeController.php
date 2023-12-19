<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home', [
            'posts_count' => Post::all()->count(),
            'users_count' => User::all()->count(),
            'categories_count' => Category::all()->count()
        ]);
    }

    public function dashboard()
    {

    }
}
