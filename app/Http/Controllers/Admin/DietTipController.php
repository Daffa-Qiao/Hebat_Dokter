<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DietTip;
use Illuminate\Http\Request;

class DietTipController extends Controller
{
    public function index()
    {
        $dietTips = DietTip::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.diet-tips.index', compact('dietTips'));
    }

    public function create()
    {
        return view('admin.diet-tips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'source_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        DietTip::create($validated);

        return redirect()->route('admin.diet-tips.index')
            ->with('success', 'Tips diet berhasil ditambahkan.');
    }

    public function edit(DietTip $dietTip)
    {
        return view('admin.diet-tips.edit', compact('dietTip'));
    }

    public function update(Request $request, DietTip $dietTip)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'source_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $dietTip->update($validated);

        return redirect()->route('admin.diet-tips.index')
            ->with('success', 'Tips diet berhasil diperbarui.');
    }

    public function destroy(DietTip $dietTip)
    {
        $dietTip->delete();

        return redirect()->route('admin.diet-tips.index')
            ->with('success', 'Tips diet berhasil dihapus.');
    }
}
