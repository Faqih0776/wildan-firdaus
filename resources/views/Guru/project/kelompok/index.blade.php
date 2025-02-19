@extends('layout2.app')

@section('konten')
<title>Kelompok Siswa</title>
<div>
    <div class="d-flex justify-content-between align-items-center">
        <h3 style="font-size: 40px; font-weight: bold; color: black;">Kelompok Siswa</h3>
        <button class="btn btn-primary btn-lg px-4 shadow" data-toggle="modal" data-target="#tambahKelompokModal">
            <i class="fa-solid fa-plus me-2"></i> Buat Kelompok
        </button>
    </div>    
    <hr style="border-top: 3px solid rgb(0, 0, 0);">

    <!-- Tabel -->
    <div class="card shadow">
        @forelse ($kelompok as $data)
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Kelompok</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0">
                <thead class="bg-dark text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Nama</th>
                        <th>Anggota Kelompok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data->kelas->nama_kelas }}</td>
                            <td class="text-center">{{ $data->nama_kelompok }}</td>
                            <td class="text-center">{{ $data->nama_kelompok }}</td>
                            <td class="text-center">{{ $data->nama_kelompok }}</td>
                        </tr>
                </tbody>
            </table>
        </div>
        @empty
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0" style="text-align: center;">Belum Ada Kelompok</h5>
        </div>
        @endforelse
    </div>
    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahKelompokModal" tabindex="-1" role="dialog" aria-labelledby="tambahKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKelompokModalLabel">Tambah Kelompok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('guru.kelompok.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kelompok">Nama Kelompok</label>
                            <input type="text" name="nama_kelompok" class="form-control" id="nama_kelompok" placeholder="Masukkan Nama Kelompok" required>
                        </div>
                        <div class="form-group">
                            <label for="kelas_id">Kelas</label>
                            <select name="kelas_id" class="form-control" id="kelas_id" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach($kelases as $kelas)
                                    <option value="{{ $kelas->kelas->id }}">{{ $kelas->kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
