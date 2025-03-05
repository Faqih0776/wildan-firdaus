@extends('layout_new.app')

@section('konten')

<title>Dashboard</title>
<div>
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4 text-primary"><b style="font-size: 40px; font-weight: bold; color: black;">Dashboard Admin</b></h1>
            <p style="color: black;">Selamat Datang di Learning Management System</p>
            <hr style="border-top: 3px solid rgb(0, 0, 0);">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0 rounded-lg text-center" style="transition: transform 0.3s;">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="fas fa-user-plus fa-3x"  style="color: blue;"></i>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary rounded-pill shadow-sm" data-toggle="modal" data-target="#tambahSiswaModal" style="background-color: blue;">Add User</button>
                    </div>
                    <h5 class="card-title">Total User : {{ $totalUser }}</h5>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0 rounded-lg text-center" style="transition: transform 0.3s;">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="fas fa-folder-plus fa-3x" style="color: blue;"></i>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary rounded-pill shadow-sm" data-toggle="modal" data-target="#addJurusanModal" style="background-color: blue;">Add Jurusan</button>
                    </div>
                    <h5 class="card-title">Total Jurusan : {{ $totalJurusan }}</h5>
                </div>
            </div>
        </div>
    </div>
            <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Tambah Siswa -->
                            <form action="{{ route('admin.siswa.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nis">NIS:</label>
                                    <input type="text" class="form-control" name="nis" id="nis" required>
                                </div>
                                <div class="form-group">
                                    <label for="nisn">NISN:</label>
                                    <input type="text" class="form-control" name="nisn" id="nisn" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Nama:</label>
                                    <input type="text" class="form-control" name="username" id="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon:</label>
                                    <input type="text" class="form-control" name="telepon" id="telepon" required>
                                </div>
                                <div class="form-group">
                                    <label for="kelas_id">Kelas:</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" required>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir:</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
    <!-- Modal Tambah Jurusan -->
    <div class="modal fade" id="addJurusanModal" tabindex="-1" role="dialog" aria-labelledby="addJurusanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content rounded">
                <div class="modal-header bg-light text-secondary">
                    <h5 class="modal-title" id="addJurusanModalLabel">Tambah Jurusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addjurusanForm" action="{{ route('admin.jurusan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kode_jurusan">Kode Jurusan</label>
                            <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_jurusan">Nama Jurusan</label>
                            <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
