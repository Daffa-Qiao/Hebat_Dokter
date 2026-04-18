<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthyMenu;
use Illuminate\Http\Request;

class HealthyMenuController extends Controller
{
    public function index()
    {
        $menus = HealthyMenu::with('doctor')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.healthy-menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.healthy-menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('healthy-menus', 'public');
        }

        HealthyMenu::create($validated);

        return redirect()->route('admin.healthy-menus.index')
            ->with('success', 'Menu sehat berhasil ditambahkan.');
    }

    public function edit(HealthyMenu $healthyMenu)
    {
        return view('admin.healthy-menus.edit', compact('healthyMenu'));
    }

    public function update(Request $request, HealthyMenu $healthyMenu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('healthy-menus', 'public');
        }

        $healthyMenu->update($validated);

        return redirect()->route('admin.healthy-menus.index')
            ->with('success', 'Menu sehat berhasil diperbarui.');
    }

    public function destroy(HealthyMenu $healthyMenu)
    {
        $healthyMenu->delete();

        return redirect()->route('admin.healthy-menus.index')
            ->with('success', 'Menu sehat berhasil dihapus.');
    }

    public function show(HealthyMenu $menu)
    {
        return view('healthy-menus.show', compact('menu'));
    }
}
