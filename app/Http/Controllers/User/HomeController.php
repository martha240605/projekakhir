<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Field; // Import model Field
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan dashboard user dengan daftar lapangan yang tersedia.
     */
    public function index()
    {
        // Hanya mengambil lapangan yang statusnya 'available' untuk ditampilkan kepada user
        $fields = Field::where('status', 'available')->orderBy('name')->get();

        return view('dashboard', compact('fields'));
    }

    /**
     * Menampilkan halaman detail untuk satu lapangan.
     * Menggunakan Route Model Binding untuk langsung mendapatkan instance Field.
     */
    public function show(Field $field) // Parameter harus Field $field (nama variabel {field} di rute)
    {
        return view('user.fields.show', compact('field'));
    }
}