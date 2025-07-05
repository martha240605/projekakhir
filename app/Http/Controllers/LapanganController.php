<?php

namespace App\Http\Controllers;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $data = Lapangan::all();
        return view('admin.lapangan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'jenis' => 'required',
            'harga_per_jam' => 'required|numeric',
        ]);

        Lapangan::create($request->all());

        return redirect()->route('lapangan.index')->with('success', 'Data lapangan berhasil ditambah');
    }

    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'jenis' => 'required',
            'harga_per_jam' => 'required|numeric',
        ]);

        $lapangan = Lapangan::findOrFail($id);
        $lapangan->update($request->all());

        return redirect()->route('lapangan.index')->with('success', 'Data lapangan berhasil diupdate');
    }

    public function destroy($id)
    {
        Lapangan::findOrFail($id)->delete();
        return redirect()->route('lapangan.index')->with('success', 'Data lapangan berhasil dihapus');
    }
}

