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

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-view {
        background-color: #4CAF50;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .text-muted {
        font-size: 14px;
    }
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
    .btn-custom {
        background-color: #4CAF50;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #45a049;
        transform: scale(1.05);
        color: #fff;
    }
    .card-body {
        padding: 20px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>

<title>Konten Belajar</title>
<div>
    <h3 style="font-size: 40px; font-weight: bold; color: black;">Ruang Proyek</h3>
    <div class="card">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 style="font-size: 15px; font-weight: bold;"><i class="fas fa-list"></i> Konten Belajar</h3>
            </div>
        </div>
        <div class="card-body">
                <!-- Tampilkan Pesan -->
                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif
        <!-- Tabel Daftar Konten -->
            <div class="row">
                        @forelse($konten as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="video-thumbnail">
                                    @if($item->link_youtube)
                                        <!-- Parsing YouTube ID -->
                                        @php
                                            parse_str(parse_url($item->link_youtube, PHP_URL_QUERY), $ytParams);
                                            $youtubeId = $ytParams['v'] ?? null;
                                        @endphp
                                        @if($youtubeId)
                                            <img style="width: 100%; height: 100%;" src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg">
                                        @else
                                            <p class="text-danger">Invalid YouTube link.</p>
                                        @endif
                                    @else
                                        <!-- Video Lokal -->
                                        <video style="width: 100%; height: 100%;">
                                            <source src="{{ asset('storage/' . $item->video_path) }}" type="video/mp4">
                                            Video tidak tersedia.
                                        </video>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h6 class="card-title text-success"><b>Judul : {{ $item->judul }}</b></h6>
                                    <p class="text-muted">Deskripsi: {{ $item->deskripsi }}</p>
                                    @if($item->link_youtube)
                                    <a href="{{ route('guru.konten.showYoutube', $item->id) }}" class="btn btn-view btn-sm">
                                        <i class="fab fa-youtube"></i> Lihat Materi
                                    </a>
                                    @else
                                    <a href="{{ route('guru.konten.showLocal', $item->id) }}" class="btn btn-view btn-sm">
                                        <i class="fas fa-file-video"></i> Lihat Materi
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
                                <a class="fa fa-plus-square" style="font-size: 80px; font-weight: bold; color: blue; position: absolute; top: 30%; width: 100%; text-align: center;" data-toggle="modal" data-target="#tambahMateriModal"></a>
                                <a style="font-size: 20px; font-weight: bold; color: blue; position: absolute; top: 55%; width: 100%; text-align: center;">Tambah Konten Belajar</a>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Konten -->
<div class="modal fade" id="tambahMateriModal" tabindex="-1" role="dialog" aria-labelledby="tambahMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMateriModalLabel">Pilih Source Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <a href="{{ route('guru.konten.createlocal') }}" class="btn btn-custom me-2">
                    <i class="fas fa-upload"></i> Upload dari Lokal
                </a>
                <a href="{{ route('guru.konten.createYoutube') }}" class="btn btn-primary">
                    <i class="fab fa-youtube"></i> Upload dari YouTube
                </a>
            </div>
            
        </div>
    </div>
</div>

@endsection
