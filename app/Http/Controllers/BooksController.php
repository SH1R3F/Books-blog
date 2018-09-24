<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Session;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id', 'DESC')->paginate(20);
        return view('admin.posted-books', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::orderBy('id', 'DESC')->get();
        $tags = \App\Tag::orderBy('id', 'DESC')->get();
        $authors = \App\Author::orderBy('id', 'DESC')->get();
        return view('admin.new-book', compact('categories', 'tags', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'title' => 'required|min:5|unique:books,book_name|max:255',
            'description' => 'required|min:10',
            'thumbnail'   => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'category' => 'nullable|integer|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'author' => 'nullable|integer|exists:authors,id',
            'bookFile' => 'required|mimes:pdf|max:30720'
        ]);

        // Storing into database
        $book = new Book;
        $book->book_name   = $request->input('title');
        $book->slug        = str_slug($request->input('title'));
        $book->description = $request->input('description');
        $book->book_file   = $request->file('bookFile')->storeAs('books', md5(uniqid()) . \Carbon\Carbon::now()->toDateTimeString());
        $book->thumbnail   = $request->file('thumbnail')->storeAs('thumbnails', md5(uniqid()) . \Carbon\Carbon::now()->toDateTimeString());
        $book->category_id = $request->input('category');
        $book->author_id   = $request->input('author');
        $book->user_id     = Auth::user()->id;
        if($book->save()){
            $book->tags()->sync($request->input('tags'), false);
            Session::flash('success', 'تم اضافة الكتاب بنجاح');
            return redirect()->route('books');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idOrSlug)
    {
        $book = Book::where('id', $idOrSlug)->orWhere('slug', $idOrSlug)->firstOrFail();
        $book->views++;
        $book->save();
        $tags = [];
        foreach($book->tags as $tag){
          $tags[$tag->id] = $tag->title;
        }
        $relatedByAuthor   = \App\Book::orderBy('id', 'DESC')->where('author_id', $book->author_id)->where('id', '!=', $book->id)->paginate(4);
        $relatedByCategory = \App\Book::orderBy('id', 'DESC')->where('category_id', $book->category_id)->where('id', '!=', $book->id)->paginate(4);

        return view('single', compact('book', 'tags', 'relatedByAuthor', 'relatedByCategory', 'comments'));
    }

    /**
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = \App\Category::orderBy('id', 'DESC')->get();
        $tags = \App\Tag::orderBy('id', 'DESC')->get();
        $authors = \App\Author::orderBy('id', 'DESC')->get();
        return view('admin.edit-book', compact('book', 'categories', 'tags', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        // Validation
        if($request->input('title') === $book->book_name){
            $this->validate($request, [
              'description' => 'required|min:10',
              'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
              'category' => 'nullable|integer|exists:categories,id',
              'tags' => 'nullable|array',
              'tags.*' => 'integer|exists:tags,id',
              'author' => 'nullable|integer|exists:authors,id',
              'bookFile' => 'nullable|mimes:pdf|max:30720'
            ]);
        }else{
            $this->validate($request, [
              'title' => 'required|min:5|unique:books,book_name|max:255',
              'description' => 'required|min:10',
              'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
              'category' => 'nullable|integer|exists:categories,id',
              'tags' => 'nullable|array',
              'tags.*' => 'integer|exists:tags,id',
              'author' => 'nullable|integer|exists:authors,id',
              'bookFile' => 'nullable|mimes:pdf|max:30720'
            ]);
        }
        // Updating
        $book->book_name   = $request->input('title');
        $book->slug        = str_slug($request->input('title'));
        $book->description = $request->input('description');
        if($request->hasFile('bookFile')){
          $book->book_file   = $request->file('bookFile')->storeAs('books', md5(uniqid()) . \Carbon\Carbon::now()->toDateTimeString());
        }
        if($request->hasFile('thumbnail')){
          $book->thumbnail   = $request->file('thumbnail')->storeAs('thumbnails', md5(uniqid()) . \Carbon\Carbon::now()->toDateTimeString());
        }
        $book->category_id = $request->input('category');
        $book->author_id   = $request->input('author');

        if($book->save()){
            $book->tags()->sync($request->input('tags'), true);
            Session::flash('success', 'البوست اتعدل بنجاح يسطا');
            return redirect()->route('books', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }

    public function download($book)
    {
        $book = Book::where('slug', $book)->firstOrFail();
        $book->downloads++;
        $book->save();
        $headers = [
            'Content-Type: application/pdf'
        ];
        $file = public_path() . '/storage/' . $book->book_file;
        return response()->download($file, $book->slug . '.pdf', $headers);
    }

    public function search()
    {
        $query = htmlspecialchars($_GET['query']);
        $books = Book::where('book_name', 'like', '%' . $query . '%')->paginate(24);
        return view('search', compact('books', 'query'));
    }
}
