<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id', 'DESC')->paginate(24);
        $bookCount = Book::count();
        return view('index', compact('books', 'bookCount'));
    }

    public function categories()
    {
        $categories = \App\Category::orderBy('id', 'DESC')->paginate(8);
        return $categories;
    }

}
