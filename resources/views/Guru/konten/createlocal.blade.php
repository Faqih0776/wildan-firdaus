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
            <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Materi (Video Local)</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.konten.storeLocal') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="mapel" class="form-label"><strong>Mata Pelajaran</strong></label>
                    <select class="form-control" id="mapel" name="mapel_id" required>
                        <option value="" disabled selected>Pilih mata pelajaran</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
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
                    <label for="video_path" class="form-label"><b>File Video</b></label>
                    <input type="file" class="form-control" id="video_path" name="video_path" accept="video/*" required>
                    <small class="text-muted">Ukuran maksimal: 100 MB</small>
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
