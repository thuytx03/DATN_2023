<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryPostController extends Controller
{
    public function index() {
        return view('admin.category-post.index');
    }
    public function create() {

    }
}
