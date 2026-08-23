<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return response()->json(BlogPost::whereNotNull('published_at')->get());
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        return view('storefront.blog.show', compact('post'));
    }

    public function store(Request $request)
    {
        // Admin only
        $blog = BlogPost::create($request->only([
            'title','slug','content','author_id','published_at'
        ]));

        return response()->json($blog, 201);
    }
}
