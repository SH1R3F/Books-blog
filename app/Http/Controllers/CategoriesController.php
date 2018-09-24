<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Error as ErrorResource;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC');
        $catCount   = $categories->count();
        $categories = $categories->paginate(16);
        return view('pages.categories', compact('categories', 'catCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = preg_replace('/\s+/', ' ', $request->all());
        $validation = Validator::make($input, [
            'title' => 'required|min:3|max:255|unique:categories,title'
        ]);
        if($validation->fails()){
            return (new ErrorResource($validation->errors()))->response()->setStatusCode(422);
        }else{
            // Make sure that slug is unique
            $count = Category::where('slug', 'like', '%' . str_slug($request->input('title')) . '%')->count();
            if($count > 0){
                $slug = str_slug($request->input('title')) . '-' . $count;
            }else{
                $slug = str_slug($request->input('title'));
            }
            $category = new Category;
            $category->title = $request->input('title');
            $category->slug  = $slug;
            if($category->save()){
                return new CategoryResource($category);
            }
        }
    }

    /**
     * Display the Category with posts data
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idOrSlug)
    {
        $category = Category::where('id', $idOrSlug)->orWhere('slug', $idOrSlug)->firstOrFail();
        $books = \App\Book::where('category_id', $category->id);
        $bookCount = $books->count();
        $books = $books->orderBy('id', 'DESC')->paginate(16);
        return view('pages.category', compact('books', 'bookCount', 'category'));
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
        $category = Category::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'title' => 'required|min:3|unique:categories,title'
        ]);
        if($validation->fails()){
            return $validation->errors();
        }else{
            $category->title = $request->input('title');
            if($category->save()){
                return $category;
            }
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
        $category = Category::findOrFail($id);
        if($category->delete()){
            return $category;
        }
    }

    public function sidebarCategories()
    {
        $categories = Category::orderBy('id','DESC')->paginate(14);
        return $categories;
    }

}
