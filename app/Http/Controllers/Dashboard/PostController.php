<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Post/Index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }
}
