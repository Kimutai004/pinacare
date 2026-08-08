<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')->latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $data['slug']      = Str::slug($request->title);
        $data['author_id'] = Auth::guard('admin')->id();

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')
            ->with('success','Blog post created successfully.');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $data['slug'] = Str::slug($request->title);
        $post->update($data);

        return redirect()->route('admin.blog.index')
            ->with('success','Blog post updated successfully.');
    }

    public function publish(BlogPost $post)
    {
        $post->update(['published_at' => now()]);
        return back()->with('success','Blog post published.');
    }

    public function unpublish(BlogPost $post)
    {
        $post->update(['published_at' => null]);
        return back()->with('success','Blog post unpublished.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();
        return redirect()->route('admin.blog.index')
            ->with('success','Blog post deleted.');
    }
}
