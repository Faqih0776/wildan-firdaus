@extends('layout2.app')

@section('konten')
<title>Edit Kelompok</title>
<div class="container">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white text-center">
            <h3>Edit Kelompok</h3>
        </div>
        <div class="card-body">
            <!-- Tampilkan pesan error jika ada -->
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form untuk mengedit tugas -->
            <form action="{{ route('guru.project.updatekelompok', $kelompok->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group mb-3">
                    <label for="nama_kelompok">Nama Kelompok</label>
                    <input type="text" class="form-control" name="nama_kelompok" id="nama_kelompok" value="{{ $kelompok->nama_kelompok }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="kelas_id">Kelas</label>
                    <select name="kelas_id" class="form-control" id="kelas_id" required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        @foreach($kelases as $kelas)
                            <option value="{{ $kelas->kelas->id }}" {{ $kelas->kelas->id == $kelompok->kelas_id ? 'selected' : '' }}>{{ $kelas->kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="jurusan_id">Jurusan</label>
                    <select name="jurusan_id" class="form-control" id="jurusan_id" required>
                        <option value="" disabled selected>Pilih Jurusan</option>
                        @foreach($kelases as $item)
                        <option value="{{ $item->jurusan->id }}" {{ $item->jurusan->id == $kelompok->jurusan_id ? 'selected' : '' }}>{{ $item->jurusan->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="user_id_1">Anggota 1</label>
                    <select name="user_id_1" class="form-control" id="user_id_1" required>
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach($siswa as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="user_id_2">Anggota 2</label>
                    <select name="user_id_2" class="form-control" id="user_id_2">
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach($siswa as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="user_id_3">Anggota 3</label>
                    <select name="user_id_3" class="form-control" id="user_id_3">
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach($siswa as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Kelompok</button>
                <a href="{{ route('guru.project.kelompok') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
