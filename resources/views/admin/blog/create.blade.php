@extends('admin.layouts.app')

@section('title', 'New Blog Post')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold text-gray-800 mb-6">Create Blog Post</h3>

    <form method="POST" action="{{ route('admin.blog.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea name="content" rows="12" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('content') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Publish At (optional - leave blank for draft)</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.blog.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Save Post</button>
        </div>
    </form>
</div>
@endsection
