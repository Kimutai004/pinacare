@extends('admin.layouts.app')

@section('title', 'Impact Metrics')

@section('content')
<div class="space-y-6">
    @if($latest)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-green-50 rounded-xl p-6 text-center">
                <p class="text-sm text-green-700">Diapers Saved</p>
                <p class="text-3xl font-bold text-green-800">{{ number_format($latest->diapers_saved) }}</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-6 text-center">
                <p class="text-sm text-blue-700">CO₂ Reduced (kg)</p>
                <p class="text-3xl font-bold text-blue-800">{{ number_format($latest->co2_reduced, 1) }}</p>
            </div>
            <div class="bg-amber-50 rounded-xl p-6 text-center">
                <p class="text-sm text-amber-700">Farmers Supported</p>
                <p class="text-3xl font-bold text-amber-800">{{ number_format($latest->farmers_supported) }}</p>
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
