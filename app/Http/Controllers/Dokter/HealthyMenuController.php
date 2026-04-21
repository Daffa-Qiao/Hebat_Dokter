<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\HealthyMenu;
use Illuminate\Http\Request;

class HealthyMenuController extends Controller
{
    public function index()
    {
        $menus = HealthyMenu::where('doctor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dokter.healthy-menus.index', compact('menus'));
    }

    public function create()
    {
        return view('dokter.healthy-menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'recipe' => 'nullable|string',
        ]);

        $validated['doctor_id'] = auth()->id();
        $validated['specialization'] = auth()->user()->specialization ?? 'Umum';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('healthy-menus', 'public');
        }

        HealthyMenu::create($validated);

        return redirect()->route('dokter.healthy-menus.index')
            ->with('success', 'Menu sehat Anda berhasil ditambahkan.');
    }

    public function edit(HealthyMenu $healthyMenu)
    {
        if ($healthyMenu->doctor_id !== auth()->id()) {
            abort(403);
        }

        return view('dokter.healthy-menus.edit', compact('healthyMenu'));
    }

    public function update(Request $request, HealthyMenu $healthyMenu)
    {
        if ($healthyMenu->doctor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'recipe' => 'nullable|string',
        ]);

        $validated['specialization'] = auth()->user()->specialization ?? 'Umum';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('healthy-menus', 'public');
        }

        $healthyMenu->update($validated);

        return redirect()->route('dokter.healthy-menus.index')
            ->with('success', 'Menu sehat Anda berhasil diperbarui.');
    }

    public function destroy(HealthyMenu $healthyMenu)
    {
        if ($healthyMenu->doctor_id !== auth()->id()) {
            abort(403);
        }

        $healthyMenu->delete();

        return redirect()->route('dokter.healthy-menus.index')
            ->with('success', 'Menu sehat Anda berhasil dihapus.');
    }
}
