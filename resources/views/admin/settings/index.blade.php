@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold text-gray-800 mb-6">Account Settings</h3>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', Auth::guard('admin')->user()->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', Auth::guard('admin')->user()->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="border-t pt-4 mt-4">
            <p class="text-sm text-gray-500 mb-3 font-medium">Change Password (leave blank to keep current)</p>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Save Settings</button>
        </div>
    </form>
</div>
@endsection
