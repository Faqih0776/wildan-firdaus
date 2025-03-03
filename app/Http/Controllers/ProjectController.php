<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
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
                ->with(['kelas', 'jurusan'])
                ->get();
    return view('guru.project.kelompok.index', compact('kelompok','kelases'));
}

public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'kelas_id' => 'required|string|max:255',
            'jurusan_id' => 'required|string|max:255',
        ]);

        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'guru_id' => auth()->id(),
        ]);

        return redirect()->route('guru.project.kelompok')->with('success', 'Kelompok successfully stored');
    }

    public function editkelompok($id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $kelases = GuruMapel::where('user_id', auth()->id())
                ->with(['kelas', 'jurusan'])
                ->get();

        $siswa = User::where('kelas_id', $kelompok->kelas_id)
                 ->where('role', 'siswa')
                 ->with(['kelas', 'siswa']) // Menyertakan relasi siswa
                 ->get();
        return view('guru.project.kelompok.edit', compact('kelompok','kelases', 'siswa'));
    }
    public function updatekelompok(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'kelas_id' => 'required|string|max:255',
            'jurusan_id' => 'required|string|max:255',
            'user_id_1' => 'required|string|max:255',
            'user_id_2' => 'required|string|max:255',
            'user_id_3' => 'required|string|max:255',
            
        ]);
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->update([
            'nama_kelompok' => $request->nama_kelompok,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'user_id_1' => $request->user_id_1,
            'user_id_2' => $request->user_id_2,
            'user_id_3' => $request->user_id_3,
        ]);
        $id1 = $request->user_id_1;
        $user1 = User::find($id1);
        $user1->update([
            'kelompok_id' => $id
        ]);
        return redirect()->route('guru.project.kelompok')->with('success', 'Data berhasil diperbarui');
    }
}
