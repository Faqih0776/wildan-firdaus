@extends('layout2.app')

@section('konten')
<style>
    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }

</style>
<title>Dashboard</title>

<div class="container mt-4">
    <h3 class="text-center mb-4">Dashboard Guru</h3>
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

        <!-- Siswa Binaan -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-user-graduate"></i> Siswa Binaan</h5>
                    <p class="h3">{{ $siswa->count() }} Siswa</p>
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
                    <h5 class="card-title text-warning"><i class="fas fa-file-upload"></i> Upload Materi/Modul</h5>
                    <p class="h3">{{ $materi->count() }} Materi</p> <!-- Menampilkan jumlah materi yang diupload -->
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Mata Pelajaran yang Diampu -->
    <div class="card shadow-sm table-responsive">
        <div class="card-body">
            <h5 class="card-title text-center">Kelas yang Diampu</h5>
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($guruJurusan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kelas->nama_kelas }}</td>
                            <td>{{ $item->jurusan->nama_jurusan }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
