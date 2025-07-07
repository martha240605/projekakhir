<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field; // Import model Field
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique (jika diperlukan)
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus gambar

class FieldController extends Controller
{
    /**
     * Menampilkan daftar semua lapangan untuk admin.
     */
    public function index()
    {
        $fields = Field::orderBy('name')->paginate(10); // Menampilkan 10 lapangan per halaman
        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Menampilkan form untuk membuat lapangan baru.
     */
    public function create()
    {
        return view('admin.fields.create');
    }

    /**
     * Menyimpan lapangan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fields,name', // Nama harus unik
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'status' => ['required', 'string', Rule::in(['available', 'maintenance', 'booked'])], // Validasi status
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('field_images', 'public'); // Simpan di storage/app/public/field_images
        }

        Field::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit lapangan.
     */
    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    /**
     * Mengupdate data lapangan di database.
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fields')->ignore($field->id), // Nama harus unik, kecuali untuk dirinya sendiri
            ],
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'status' => ['required', 'string', Rule::in(['available', 'maintenance', 'booked'])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($field->image) {
                Storage::disk('public')->delete($field->image);
            }
            $imagePath = $request->file('image')->store('field_images', 'public');
            $field->image = $imagePath;
        } elseif ($request->input('clear_image')) { // Tambahkan input hidden di form untuk hapus gambar
            if ($field->image) {
                Storage::disk('public')->delete($field->image);
            }
            $field->image = null;
        }

        $field->name = $request->name;
        $field->type = $request->type;
        $field->description = $request->description;
        $field->price_per_hour = $request->price_per_hour;
        $field->status = $request->status;
        $field->save(); // Simpan perubahan

        // Setelah update, data akan otomatis terupdate di dashboard user
        // asalkan user merefresh halamannya, karena user dashboard query ulang data terbaru.

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui!');
    }

    /**
     * Menghapus lapangan dari database.
     */
    public function destroy(Field $field)
    {
        // Hapus gambar terkait jika ada
        if ($field->image) {
            Storage::disk('public')->delete($field->image);
        }

        $field->delete();

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus!');
    }
}