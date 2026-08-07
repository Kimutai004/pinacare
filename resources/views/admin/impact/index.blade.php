@extends('admin.layouts.app')

@section('title', 'Impact Metrics')

@section('content')
<div class="space-y-6">
    <!-- Impact hero -->
    <div class="relative overflow-hidden rounded-2xl bg-green-700 text-white p-6 shadow-lg">
        <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/10"></div>
        <div class="absolute left-56 bottom-0 w-3 h-3 rounded-full bg-lime-400/50 animate-pulse"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-lime-300">
                    <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Sustainability Impact</h1>
                <p class="text-green-100 text-sm">Every product sold helps reduce waste, carbon, and supports farming communities.</p>
            </div>
        </div>
    </div>

    @if($latest)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
<div class="bg-green-50 rounded-xl p-6 text-center border border-green-200">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white mb-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                    </svg>
                </div>
                <p class="text-sm text-green-700 font-medium">Diapers Saved</p>
                <p class="text-3xl font-bold text-green-800 mt-1">{{ number_format($latest->diapers_saved) }}</p>
            </div>
<div class="bg-blue-50 rounded-xl p-6 text-center border border-blue-200">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 text-white mb-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M12 3v2M5.6 5.6l1.4 1.4M2 12h2M18.4 5.6l-1.4 1.4M20 12h2M17 16a5 5 0 10-10 0c0 3 2 4 5 4s5-1 5-4zM12 22v-2"/>
                    </svg>
                </div>
                <p class="text-sm text-blue-700 font-medium">CO₂ Reduced (kg)</p>
                <p class="text-3xl font-bold text-blue-800 mt-1">{{ number_format($latest->co2_reduced, 1) }}</p>
            </div>
<div class="bg-amber-50 rounded-xl p-6 text-center border border-amber-200">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-500 text-white mb-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M3 12h18M3 12a9 9 0 0118 0M3 12l3 6h4l-1-6M21 12l-3 6h-4l1-6M12 3v9M12 18v3"/>
                    </svg>
                </div>
                <p class="text-sm text-amber-700 font-medium">Farmers Supported</p>
                <p class="text-3xl font-bold text-amber-800 mt-1">{{ number_format($latest->farmers_supported) }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <h3 class="font-semibold text-gray-800 mb-4">Update Impact Metrics</h3>
        <p class="text-sm text-gray-500 mb-4">Impact metrics auto-update after sales. Use this form to record a new snapshot or make manual adjustments.</p>

        <form method="POST" action="{{ route('admin.impact.update') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diapers Saved</label>
                <input type="number" name="diapers_saved" value="{{ old('diapers_saved', $latest?->diapers_saved ?? 0) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CO₂ Reduced (kg)</label>
                <input type="number" step="0.1" name="co2_reduced" value="{{ old('co2_reduced', $latest?->co2_reduced ?? 0) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Farmers Supported</label>
                <input type="number" name="farmers_supported" value="{{ old('farmers_supported', $latest?->farmers_supported ?? 0) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <button class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Save Metrics</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Metric History</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Diapers Saved</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">CO₂ Reduced</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Farmers Supported</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($metrics as $m)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($m->diapers_saved) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($m->co2_reduced, 1) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($m->farmers_supported) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $m->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No metrics recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $metrics->links() }}</div>
    </div>
</div>
@endsection
