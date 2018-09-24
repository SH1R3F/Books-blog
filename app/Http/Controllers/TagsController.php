<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Validator;
use App\Http\Resources\Error as ErrorResource;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC');
        $tagsCount   = $tags->count();
        $tags = $tags->paginate(16);
        return view('pages.tags', compact('tags', 'tagsCount'));
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
        $validation = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255|unique:tags,title'
        ]);
        if($validation->fails()){
            return (new ErrorResource($validation->errors()))->response()->setStatusCode(422);
        }else{
            // Make sure that slug is unique
            $count = Tag::where('slug', 'like', '%' . str_slug($request->input('title')) . '%')->count();
            if($count > 0){
                $slug = str_slug($request->input('title')) . '-' . $count;
            }else{
                $slug = str_slug($request->input('title'));
            }
            $tag = new Tag;
            $tag->title = $request->input('title');
            $tag->slug  = $slug;
            if($tag->save()){
                return $tag;
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
        $tag = Tag::where('id', $idOrSlug)->orWhere('slug', $idOrSlug)->firstOrFail();
        $bookCount = $tag->books()->count();
        $books = $tag->books()->orderBy('id', 'DESC')->paginate(16);
        return view('pages.tag', compact('bookCount', 'books', 'tag'));
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
        $tag = Tag::findOrFail($id);
        if($tag->delete()){
            return $tag;
        }
    }

    public function sidebarTags()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(14);
        return $tags;
    }
}
