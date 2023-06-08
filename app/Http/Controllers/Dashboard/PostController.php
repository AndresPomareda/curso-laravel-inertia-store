<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutPostRequest;
use App\Http\Requests\Post\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(4);
        return inertia("Dashboard/Post/Index",compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return inertia("Dashboard/Post/Create",compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
      //sleep(5);
      Post::create($request->validated());
      return to_route('post.index')->with('message',"Created post successfully");
   }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia("Dashboard/Post/Edit", compact('post','categories'));
    }


    public function update(PutPostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return redirect()->route('post.index')->with('message',"Updated post successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('message',"Deleted post successfully");
    }
}
