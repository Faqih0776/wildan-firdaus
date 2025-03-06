@extends('layout2.app')

@section('konten')
<style>
    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }

</style>
<title>Ruang Proyek</title>

<div>
    <h3 style="font-size: 40px; font-weight: bold; color: black;">Ruang Proyek</h3>
    <hr style="border-top: 3px solid rgb(0, 0, 0);">
    <div class="row mb-4">
        <!-- Kelas yang Diampu -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-chalkboard-teacher"></i> Kelas yang Diampu</h5>
                    <p class="h3">{{ $guruJurusan->count() }} Kelas</p>
                </div>
            </div>
        </div>

        <!-- Proyek Siswa -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success" style="font-size: 15px; font-weight: bold;"><i class="fas fa-user-graduate"></i> Proyek Siswa</h5>
                    <a href="{{ route('guru.project') }}" class="btn rounded-pill" style="background-color: blue; color: white;">Lihat Proyek Siswa</a>
                </div>
            </div>
        </div>

        <!-- Mapel yang Diampu -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info"><i class="fas fa-book-open"></i> Jurusan yang Diampu</h5>
                    <p class="h3">{{ $guruJurusan->groupBy('jurusan_id')->count() }} Jurusan</p>
                </div>
            </div>
        </div>

        <!-- Upload Materi/Modul -->
        <div class="col-md-3 ">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning" style="font-size: 15px; font-weight: bold;"><i class="fas fa-file-upload"></i> Konten Belajar</h5>
                    <a href="{{ route('guru.konten') }}" class="btn rounded-pill" style="background-color: blue; color: white;">Lihat Konten Belajar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
