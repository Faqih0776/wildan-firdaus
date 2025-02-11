<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
use App\Models\Siswa;

class AbsenController extends Controller
{
    // Halaman utama siswa
    public function index()
    {
        $absensi = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal_absen', Carbon::today())
            ->orderBy('tanggal_absen', 'desc')
            ->get();
        $users = User::all();
        return view('siswa.absen.index', compact('absensi', 'users',));
    }

    public function create()
    {
        $absensi = Absensi::where('user_id', Auth::id())->get();
        $users = User::all();
        return view('siswa.absen.index', compact('users', 'absensi')); //update
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        // $request->validate([
        //     'id_user' => 'required|exists:users,id',
        // ]);
        // Get the current time
        $currentTime = Carbon::now('Asia/Jakarta');

        // untuk mengecek apakah user ditemukan
        $users = User::find($request->user_id);
        if (!$users) {
            return redirect()->route('siswa.absen.create')->with('error', 'User tidak ditemukan!');
        }

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('user_id', $users->id)->whereDate('created_at', today())->first();
        if ($sudahAbsen) {
            return redirect()->route('siswa.absen.index')->with('error', 'Anda telah melakukan Absen Hari Ini!');
        }
        $note = null;
        $latenessTime = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');
        if ($currentTime->greaterThan($latenessTime)) {
            $note = 'Telat';
        }
        // Ambil waktu sekarang
        $jamMasuk = now()->format('H:i'); // atau bisa gunakan Carbon::now()

        Absensi::create([
            'user_id' => $request->user_id,
            'tanggal_absen' => now()->format('Y-m-d'), // format tanggal
            'jam_masuk' => $jamMasuk, // format jam
            'note' => $note,
        ]);

        return redirect()->route('siswa.absen.index')->with('success', 'Absen Masuk berhasil disimpan!');
    }

}
