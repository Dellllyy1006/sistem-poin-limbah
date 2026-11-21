<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WasteCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = WasteCategory::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function edit(WasteCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, WasteCategory $category)
    {
        // Strictly only Botol and Kaleng are permitted in the system per Rules.md
        if (!in_array($category->name, ['Botol', 'Kaleng'])) {
            return back()->with('error', 'Kategori ini tidak diizinkan oleh aturan sistem.');
        }

        $validated = $request->validate([
            'unit_divisor' => ['required', 'integer', 'min:1'],
            'base_point' => ['required', 'integer', 'min:1'],
        ], [
            'unit_divisor.required' => 'Nilai pembagi satuan wajib diisi.',
            'unit_divisor.min' => 'Nilai pembagi minimal 1.',
            'base_point.required' => 'Poin dasar wajib diisi.',
            'base_point.min' => 'Poin dasar minimal 1.',
        ]);

        $category->update([
            'unit_divisor' => $validated['unit_divisor'],
            'base_point' => $validated['base_point'],
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Parameter kategori ' . $category->name . ' berhasil diperbarui.');
    }
}
