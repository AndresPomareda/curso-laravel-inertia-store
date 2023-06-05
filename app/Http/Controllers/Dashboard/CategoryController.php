<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Category\Put;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Category\Store;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(4);
        return inertia("Dashboard/Category/Index",compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Dashboard/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
      //sleep(5);
      Category::create($request->validated());
      return to_route('category.index')->with('message',"Created category successfully");
   }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Category $category)
    {
        return inertia("Dashboard/Category/Edit", compact('category'));
    }


    public function update(Store $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('category.index')->with('message',"Updated category successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('category.index')->with('message',"Deleted category successfully");
    }
}
