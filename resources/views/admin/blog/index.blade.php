@extends('admin.layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Blog Posts</h3>
        <a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">+ New Post</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Published</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $post->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $post->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $post->author?->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $post->published_at ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $post->published_at ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M Y') : '—' }}</td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.blog.edit', $post) }}" class="text-xs text-blue-600 hover:text-blue-800">Edit</a>
                            @if($post->published_at)
                                <form method="POST" action="{{ route('admin.blog.unpublish', $post) }}" class="inline">
                                    @csrf @method('PUT')
                                    <button class="text-xs text-yellow-600 hover:text-yellow-800">Unpublish</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.blog.publish', $post) }}" class="inline">
                                    @csrf @method('PUT')
                                    <button class="text-xs text-green-600 hover:text-green-800">Publish</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" class="inline" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No blog posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
