<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    public function dashboard()
    {
        $mostBooks = \App\Book::orderBy('views', 'DESC')->paginate(7);
        $lastComments = \App\Comment::orderBy('id', 'DESC')->paginate(7);
        return view('admin.panel', compact('mostBooks', 'lastComments'));
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(16);
        return view('admin.categories', compact('categories'));
    }

    public function tags()
    {
        $tags = \App\Tag::orderBy('id', 'DESC')->paginate(16);
        return view('admin.tags', compact('tags'));
    }

    public function authors()
    {
        $authors = \App\Author::orderBy('id', 'DESC')->paginate(16);
        return view('admin.authors', compact('authors'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

}
