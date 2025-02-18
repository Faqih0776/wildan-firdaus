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
        <!-- Kelompok Siswa -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <a href="#" class="btn" style="background-color: blue; color: white;">Lihat Kelompok</a>
                </div>
            </div>
        </div>
        <!-- Tugas Proyek Kelompok -->
        <div class="col-md-3 ">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <a href="#" class="btn" style="background-color: blue; color: white;">Lihat Tugas Project</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
