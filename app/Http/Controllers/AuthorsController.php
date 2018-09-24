<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Validator;
use App\Http\Resources\Error as ErrorResource;
use Illuminate\Support\Facades\Input;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('id', 'DESC');
        $authorsCount   = $authors->count();
        $authors = $authors->paginate(16);
        return view('pages.authors', compact('authors', 'authorsCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = preg_replace("!\s+!", ' ', $request->all());
        $validation = Validator::make($input, [
            'name' => 'required|min:3|max:255|unique:authors,author_name'
        ]);
        if($validation->fails()){
            return (new ErrorResource($validation->errors()))->response()->setStatusCode(422);
        }else{
            // Make sure that slug is unique
            $count = Author::where('slug', 'like', '%' . str_slug($request->input('name')) . '%')->count();
            if($count > 0){
                $slug = str_slug($request->input('name')) . '-' . $count;
            }else{
                $slug = str_slug($request->input('name'));
            }
            $author = new Author;
            $author->author_name = $request->input('name');
            $author->slug = $slug;
            if($author->save()){
                return $author;
            }
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
        $author = Author::where('id', $idOrSlug)->orWhere('slug', $idOrSlug)->firstOrFail();
        $bookCount = $author->books()->count();
        $books = $author->books()->orderBy('id', 'DESC')->paginate(16);
        return view('pages.author', compact('bookCount', 'books', 'author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        if($author->delete()){
            return $author;
        }
    }

    public function sidebarAuthors()
    {
        $authors = Author::orderBy('id', 'DESC')->paginate(14);
        return $authors;
    }
}
