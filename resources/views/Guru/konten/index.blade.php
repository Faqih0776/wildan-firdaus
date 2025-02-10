@extends('layout2.app')
@section('konten')

<style>
    .modal-header {
        background-color: #007bff;
        color: #fff;
    }
    .modal-title {
        font-weight: bold;
    }
    .table {
        background-color: #fff;
    }
    .table thead th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
    }
    .table tbody td {
        text-align: center;
        vertical-align: middle;
    }
    .btn {
        font-size: 0.9rem;
    }
    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }

</style>

<title>Konten Belajar</title>
<div>
    <h3 style="font-size: 40px; font-weight: bold; color: black;">Ruang Proyek</h3>
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 style="font-size: 15px; font-weight: bold;"><i class="fas fa-list"></i> Konten Belajar</h3>
        </div>
    </div>
    <div class="card">
            <!-- Tampilkan Pesan -->
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
    <!-- Tabel Daftar Materi -->
        <div class="row">
                    @forelse($materi as $video)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="video-thumbnail">
                                @if($video->link_youtube)
                                    <!-- Parsing YouTube ID -->
                                    @php
                                        parse_str(parse_url($video->link_youtube, PHP_URL_QUERY), $ytParams);
                                        $youtubeId = $ytParams['v'] ?? null;
                                    @endphp
                                    @if($youtubeId)
                                        <iframe src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg" allowfullscreen></iframe>
                                    @else
                                        <p class="text-danger">Invalid YouTube link.</p>
                                    @endif
                                @else
                                    <!-- Video Lokal -->
                                    <video style="width: 100%; height: 100%;">
                                        <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                        Video tidak tersedia.
                                    </video>
                                @endif
                            </div>

                            <div class="card-body">
                                @if($video->link_youtube)
                                <a href="{{ $video->link_youtube }}" target="_blank" class="btn btn-view btn-sm">
                                    <i class="fab fa-youtube"></i> Tonton di YouTube
                                </a>
                                @else
                                <a href="{{ asset('storage/' . $video->file_path) }}" target="_blank" class="btn btn-view btn-sm">
                                    <i class="fas fa-file-video"></i> Tonton Video
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-4 mb-4">
                        <p style="height: 356px; width: 294px;">
                            <i class="fas fa-info-circle" style="font-size: 80px; font-weight: bold; position: absolute; top: 30%; width: 100%; text-align: center;"></i>
                            <i style="position: absolute; top: 55%; width: 100%; text-align: center;">Belum ada konten yang tersedia.</i>
                        </p>
                    </div>
                    @endforelse
                    <div class="col-md-4 mb-4">
                        <div style="height: 356px; width: 294px;">
                            <i class="fa fa-plus-square" style="font-size: 80px; font-weight: bold; color: blue; position: absolute; top: 30%; width: 100%; text-align: center;"></i>
                            <a href="" style="font-size: 20px; font-weight: bold; position: absolute; top: 55%; width: 100%; text-align: center;">Tambah Konten Belajar</a>
                        </div>
                    </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Materi -->
<div class="modal fade" id="tambahMateriModal" tabindex="-1" role="dialog" aria-labelledby="tambahMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMateriModalLabel">Tambah Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Judul Modul / Materi</label>
                        <input type="text" name="judul" class="form-control" id="judul" placeholder="Masukkan judul materi" required>
                    </div>
                    <div class="form-group">
                        <label for="mapel_id">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" id="mapel_id" required>
                            <option value="" disabled selected>Pilih Mata Pelajaran</option>
                            @foreach($mapels as $guruMapel)
                                <option value="{{ $guruMapel->mapel->id }}">{{ $guruMapel->mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" class="form-control" id="kelas_id" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            @foreach($mapels as $guruMapel)
                                <option value="{{ $guruMapel->kelas->id }}">{{ $guruMapel->kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" name="file" class="form-control-file" id="file" required>
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

@endsection
