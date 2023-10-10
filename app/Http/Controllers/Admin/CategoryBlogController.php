<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryBlogController extends Controller
{
    public function index() {
        return view('admin.category-blog.index');

    }
    public function create() {

    }
}
