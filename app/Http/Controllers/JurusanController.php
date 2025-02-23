<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    // Menampilkan daftar jurusan
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('admin.jurusan.index', compact('jurusan'));
    }

    // Menampilkan form untuk menambahkan jurusan baru
    public function create()
    {
        return view('admin.jurusan.create');
    }

    // Menyimpan jurusan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required',
        ]);

        Jurusan::create($request->all());
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    // Menampilkan form edit untuk jurusan
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    // Memperbarui data jurusan di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->all());

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    // Menghapus jurusan dari database
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
