<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;


class PainelController extends Controller
{
    public function index()
    {
        $userTotal = User::count();
        $catTotal = Category::count();
        $postTotal = Post::count();
        $commentTotal = Comment::where('status', 'R')->count();
        $profileTotal = Profile::count();
        $permissionTotal = Permission::count();

        return view('painel.home.index', compact('userTotal', 'catTotal',
            'postTotal', 'commentTotal', 'profileTotal', 'permissionTotal'));
    }
}
