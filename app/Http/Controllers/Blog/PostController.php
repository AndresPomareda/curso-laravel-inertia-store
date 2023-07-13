<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $search = request('search');
        $from = request('from');
        $to = request('to');
        $type = request('type');
        $category_id = request('category_id');

        $posts = Post::with('category')->where('posted', 'yes');

        if (request('search')) {
            $posts->where(function ($query) {
                $query->orWhere("id", "like", "%" . request("search") . "%")
                    ->orWhere("title", "like", "%" . request("search") . "%")
                    ->orWhere("description", "like", "%" . request("search") . "%");
            });
        }

        if (request('from') && request('to')) {
            $posts->whereBetween('date', [date(request("from")), date(request("to"))]);
        }

        if (request('type')) {
            $posts->where('type', request("type"));
        }
        if (request('category_id')) {
            $posts->where('category_id', request("category_id"));
        }

        $posts = $posts->paginate(10);

        return inertia("Blog/Index", ["posts" => $posts,
                                    "categories" => $categories,
                                    "prop_category_id" => $category_id,
                                    "prop_type" => $type,
                                    "prop_from" => $from,
                                    "prop_to" => $to,
                                    "prop_search" => $search,]);
    }
    public function show(Post $post)
    {
        $post->category;
        Inertia::share('step', getStep());
        return inertia("Blog/Show", compact('post'));
    }
}
