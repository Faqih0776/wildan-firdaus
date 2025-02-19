<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Kelompok;
use App\Models\Mapel; // Model untuk Mata Pelajaran
use App\Models\GuruMapel; // Model untuk Mata Pelajaran
use App\Models\Kelas; // Model untuk Kelas

class ProjectController extends Controller
{
    //
    public function index()
{
    return view('guru.project.index');
}

    public function indexkelompok()
{
    // Ambil data kelompok yang dibuat oleh guru yang sedang login
    $kelompok = Kelompok::with(['kelas'])
                ->where('guru_id', auth()->id()) // Hanya untuk guru yang sedang login
                ->get();

    $kelases = GuruMapel::where('user_id', auth()->id())
                ->with(['kelas'])
                ->get();
    return view('guru.project.kelompok.index', compact('kelompok','kelases'));
}

public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'kelas_id' => 'required|string|max:255',
        ]);

        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'kelas_id' => $request->kelas_id,
            'guru_id' => auth()->id(),
        ]);

        return redirect()->route('guru.project.kelompok')->with('success', 'Kelompok successfully stored');
    }

}
