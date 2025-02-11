<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Konten;
use App\Models\Mapel; // Model untuk Mata Pelajaran
use App\Models\GuruMapel; // Model untuk Mata Pelajaran
use App\Models\Kelas; // Model untuk Kelas

class KontenController extends Controller
{
    //
    public function index()
{
    $userId = auth()->user()->id; // ID user yang login

    // Ambil mata pelajaran yang diampu oleh guru
    $mapel = GuruMapel::where('user_id', $userId)
            ->join('mapels', 'guru_mapels.mapel_id', '=', 'mapels.id')
            ->select('mapels.id', 'mapels.nama_mapel')
            ->distinct()
            ->get();

    // Ambil kelas yang diampu oleh guru
    $kelas = GuruMapel::where('user_id', $userId)
            ->join('kelas', 'guru_mapels.kelas_id', '=', 'kelas.id')
            ->select('kelas.id', 'kelas.nama_kelas')
            ->distinct()
            ->get();

    // Ambil video yang hanya terkait dengan mata pelajaran dan kelas yang diampu
    $konten = Konten::with(['mapel', 'kelas']) // Pastikan relasi mapel dan kelas diload
            ->whereHas('mapel', function ($query) use ($mapel) {
                $query->whereIn('id', $mapel->pluck('id')); // Filter berdasarkan mata pelajaran
            })
            ->whereHas('kelas', function ($query) use ($kelas) {
                $query->whereIn('id', $kelas->pluck('id')); // Filter berdasarkan kelas
            })
            ->get();

    return view('guru.konten.index', compact('konten', 'kelas', 'mapel'));
}

public function createlocal()
    {
        $userId = auth()->user()->id; // ID user yang login

        // Ambil mata pelajaran yang diampu oleh guru
        $mapels = GuruMapel::where('user_id', $userId)
                ->join('mapels', 'guru_mapels.mapel_id', '=', 'mapels.id')
                ->select('mapels.id', 'mapels.nama_mapel')
                ->distinct()
                ->get();
    
        // Ambil kelas yang diampu oleh guru
        $kelases = GuruMapel::where('user_id', $userId)
                ->join('kelas', 'guru_mapels.kelas_id', '=', 'kelas.id')
                ->select('kelas.id', 'kelas.nama_kelas')
                ->distinct()
                ->get();

        // Mengirim semua variabel ke view
        return view('guru.konten.createlocal', compact('mapels', 'kelases'));
    }

    // Simpan video dari file lokal
    public function storeLocal(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:500',
            'mapel_id' => 'required|string|max:255',
            'kelas_id' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'video_path' => 'required|file|mimes:mp4,avi,mkv|max:102400', // Maksimal 100MB (102400 KB)
        ]);
        // Proses upload file materi
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/materi', $fileName, 'public');

            // Cek jika proses upload gagal
            if (!$filePath) {
                return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan atau format tidak sesuai.');
        }

        $filePaths = $request->file('video_path')->store('videos', 'public');

        Konten::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'file_path' => $filePath,
            'video_path' => $filePaths,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('guru.konten')->with('success', 'Konten Belajar berhasil diunggah dari lokal!');
    }
    public function showLocal($id)
    {
        $userId = auth()->user()->id; // ID user yang login

        // Ambil mata pelajaran yang diampu oleh guru
        $mapel = GuruMapel::where('user_id', $userId)
                ->join('mapels', 'guru_mapels.mapel_id', '=', 'mapels.id')
                ->select('mapels.id', 'mapels.nama_mapel')
                ->distinct()
                ->get();

        // Ambil kelas yang diampu oleh guru
        $kelas = GuruMapel::where('user_id', $userId)
                ->join('kelas', 'guru_mapels.kelas_id', '=', 'kelas.id')
                ->select('kelas.id', 'kelas.nama_kelas')
                ->distinct()
                ->get();

        // Mengambil data materi berdasarkan ID
        $konten = Konten::with(['mapel', 'kelas', 'user'])->findOrFail($id);

        return view('guru.konten.showguru', compact('konten', 'kelas', 'mapel'));
    }

    public function destroyLocal($id)
    {
        // Menghapus ujian
        $konten = Konten::findOrFail($id);
        $Konten->delete();
        return redirect()->route('guru.konten.index')->with('success', 'Konten berhasil dihapus.');
    }

    public function updateLocal(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:500',
            'mapel_id' => 'required|integer',
            'kelas_id' => 'required|integer',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'video_path' => 'required|file|mimes:mp4,avi,mkv|max:102400',
        ]);

        $konten = Konten::findOrFail($id);

        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->mapel_id = $request->mapel_id;
        $konten->kelas_id = $request->kelas_id;

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($konten->file_path && Storage::disk('public')->exists($konten->file_path)) {
                Storage::disk('public')->delete($konten->file_path);
            }

            $filePath = $request->file('file')->store('uploads/materi', 'public');

            // Cek jika proses upload gagal
            if (!$filePath) {
                return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }

            $konten->file_path = $filePath;
        }

        if ($request->hasFile('video_path')) {
            // Hapus file lama jika ada
            if ($konten->video_path && Storage::disk('public')->exists($konten->video_path)) {
                Storage::disk('public')->delete($konten->video_path);
            }

            $filePaths = $request->file('video_path')->store('videos', 'public');

            // Cek jika proses upload gagal
            if (!$filePaths) {
                return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }

            $konten->video_path = $filePaths;
        }

        $konten->save();

        return redirect()->route('guru.konten')->with('success', 'Materi berhasil diperbarui');
    }

    public function createYoutube()
    {
        $userId = auth()->user()->id; // ID user yang login

        // Ambil mata pelajaran yang diampu oleh guru
        $mapels = GuruMapel::where('user_id', $userId)
                ->join('mapels', 'guru_mapels.mapel_id', '=', 'mapels.id')
                ->select('mapels.id', 'mapels.nama_mapel')
                ->distinct()
                ->get();
    
        // Ambil kelas yang diampu oleh guru
        $kelases = GuruMapel::where('user_id', $userId)
                ->join('kelas', 'guru_mapels.kelas_id', '=', 'kelas.id')
                ->select('kelas.id', 'kelas.nama_kelas')
                ->distinct()
                ->get();

        // Mengirim semua variabel ke view
        return view('guru.konten.createYoutube', compact('mapels', 'kelases'));
    }

    // Simpan video dari file lokal
    public function storeYoutube(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:500',
            'mapel_id' => 'required|string|max:255',
            'kelas_id' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'link_youtube' => 'required|url',
        ]);
        // Proses upload file materi
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/materi', $fileName, 'public');

            // Cek jika proses upload gagal
            if (!$filePath) {
                return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan atau format tidak sesuai.');
        }


        Konten::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'file_path' => $filePath,
            'link_youtube' => $request->link_youtube,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('guru.konten')->with('success', 'Konten Belajar berhasil diunggah dari Youtube!');
    }
    public function showYoutube($id)
    {
        $userId = auth()->user()->id; // ID user yang login

        // Ambil mata pelajaran yang diampu oleh guru
        $mapel = GuruMapel::where('user_id', $userId)
                ->join('mapels', 'guru_mapels.mapel_id', '=', 'mapels.id')
                ->select('mapels.id', 'mapels.nama_mapel')
                ->distinct()
                ->get();

        // Ambil kelas yang diampu oleh guru
        $kelas = GuruMapel::where('user_id', $userId)
                ->join('kelas', 'guru_mapels.kelas_id', '=', 'kelas.id')
                ->select('kelas.id', 'kelas.nama_kelas')
                ->distinct()
                ->get();

        // Mengambil data materi berdasarkan ID
        $konten = Konten::with(['mapel', 'kelas', 'user'])->findOrFail($id);

        return view('guru.konten.showguruyt', compact('konten', 'kelas', 'mapel'));
    }

    public function destroyYoutube($id)
    {
        // Menghapus ujian
        $konten = Konten::findOrFail($id);
        $Konten->delete();
        return redirect()->route('guru.konten.index')->with('success', 'Konten berhasil dihapus.');
    }

    public function updateYoutube(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:500',
            'mapel_id' => 'required|integer',
            'kelas_id' => 'required|integer',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'link_youtube' => 'required|url',
        ]);

        $konten = Konten::findOrFail($id);

        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->mapel_id = $request->mapel_id;
        $konten->kelas_id = $request->kelas_id;
        $konten->link_youtube = $request->link_youtube;

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($konten->file_path && Storage::disk('public')->exists($konten->file_path)) {
                Storage::disk('public')->delete($konten->file_path);
            }

            $filePath = $request->file('file')->store('uploads/materi', 'public');

            // Cek jika proses upload gagal
            if (!$filePath) {
                return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }

            $konten->file_path = $filePath;
        }

        $konten->save();

        return redirect()->route('guru.konten')->with('success', 'Materi berhasil diperbarui');
    }
}
