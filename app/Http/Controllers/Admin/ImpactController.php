<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImpactMetric;
use Illuminate\Http\Request;

class ImpactController extends Controller
{
    public function index()
    {
        $metrics = ImpactMetric::orderByDesc('created_at')->paginate(10);
        $latest  = ImpactMetric::latest()->first();
        return view('admin.impact.index', compact('metrics','latest'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'diapers_saved'     => 'required|integer|min:0',
            'co2_reduced'       => 'required|numeric|min:0',
            'farmers_supported' => 'required|integer|min:0',
        ]);

        ImpactMetric::create($data);

        return back()->with('success','Impact metrics updated successfully.');
    }
}
