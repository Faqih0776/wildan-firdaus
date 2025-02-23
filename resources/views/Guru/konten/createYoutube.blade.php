@extends('layout2.app')

@section('konten')

<style>
#loading {
    display: none; /* Spinner default tersembunyi */
}

#loading .spinner-border {
    width: 3rem;
    height: 3rem;
}
    .table-responsive {
        overflow-x: auto;
    }
    .card {
        border: none;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .btn {
        transition: background-color 0.3s, color 0.3s;
    }
    .btn:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Materi (Youtube)</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.konten.storeYoutube') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul Ujian -->
                <div class="form-group mb-3">
                    <label for="judul" class="form-label"><strong>Judul Materi</strong></label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul ujian" required>
                </div>

                <!-- Deskripsi -->
                <div class="form-group mb-3">
                    <label for="deskripsi" class="form-label"><strong>Deskripsi Materi</strong></label>
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi" required>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group mb-3">
                    <label for="jurusan_id" class="form-label"><strong>Mata Pelajaran</strong></label>
                    <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                        <option value="" disabled selected>Pilih mata pelajaran</option>
                        @foreach($jurusan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelas -->
                <div class="form-group mb-3">
                    <label for="kelas" class="form-label"><strong>Kelas</strong></label>
                    <select class="form-control" id="kelas" name="kelas_id" required>
                        <option value="" disabled selected>Pilih kelas</option>
                        @foreach($kelases as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="file" class="form-label"><b>File Materi</b></label>
                    <input type="file" name="file" class="form-control" id="file" required>
                </div>

                <div class="form-group mb-3">
                    <label for="link_youtube" class="form-label"><b>Link YouTube</b></label>
                    <input type="url" class="form-control" id="link_youtube" name="link_youtube" placeholder="https://youtube.com/..." required>
                </div>

                <!-- Tombol Simpan -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
