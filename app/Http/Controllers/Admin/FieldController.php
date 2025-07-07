<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field; // Pastikan model Field sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload file

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = Field::orderBy('name')->paginate(10); // Ambil semua lapangan dengan paginasi
        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('field_images', 'public');
        }

        Field::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        // Method show ini jarang digunakan untuk resource controller di admin panel,
        // biasanya langsung ke edit atau index. Tapi bisa ditambahkan jika ada halaman detail.
        return view('admin.fields.show', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $field->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('field_images', 'public');
        }

        $field->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        // Hapus gambar terkait jika ada
        if ($field->image && Storage::disk('public')->exists($field->image)) {
            Storage::disk('public')->delete($field->image);
        }
        $field->delete();
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus!');
    }
}