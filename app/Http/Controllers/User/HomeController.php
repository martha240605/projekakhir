<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Field; // Pastikan model Field sudah ada
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the fields for users.
     */
    public function index()
    {
        // Ambil semua lapangan yang tersedia, bisa ditambahkan filter atau search nanti
        $fields = Field::orderBy('name')->paginate(10);
        return view('user.home', compact('fields'));
    }

    /**
     * Display the specified field detail.
     */
    public function show(Field $field)
    {
        return view('user.field_detail', compact('field'));
    }
}