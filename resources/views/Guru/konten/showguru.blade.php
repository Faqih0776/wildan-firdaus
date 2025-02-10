@extends('layout2.app')

@section('konten')
<title>Lihat Konten Belajar</title>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-book-open mr-2"></i> Detail Konten Belajar</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-4">
                        {{-- Tampilan Video --}}
                        <div class="mb-4">
                            <div class="mb-4">
                                <div class="mb-4">
                                    @if($konten->link_youtube)
                                        <!-- Parsing YouTube ID -->
                                        @php
                                            parse_str(parse_url($konten->link_youtube, PHP_URL_QUERY), $ytParams);
                                            $youtubeId = $ytParams['v'] ?? null;
                                        @endphp
                                        @if($youtubeId)
                                            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen></iframe>
                                        @else
                                            <p class="text-danger">Invalid YouTube link.</p>
                                        @endif
                                    @else
                                        <!-- Video Lokal -->
                                        <video controls style="width: 100%; height: 100%;">
                                            <source src="{{ asset('storage/' . $konten->video_path) }}" type="video/mp4">
                                            Video tidak tersedia.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="text-primary">Judul</h5>
                        <p class="text-muted">{{ $konten->judul }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary">Deskripsi</h5>
                        <p class="text-muted">{{ $konten->deskripsi }}</p>
                    </div>

                    <div class="mb-4">
                        @if($konten->file_path)
                            <a href="{{ asset('storage/' . $konten->file_path) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-download mr-2"></i> Lihat E-Book
                            </a>
                            <a href="{{ asset('storage/' . $konten->video_path) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-file-video"></i> Lihat Video
                            </a>
                        @else
                            <p class="text-muted">Tidak ada file</p>
                        @endif
                    </div>
                    <hr style="border-top: 3px solid rgb(0, 0, 0);">
                    <div class="mb-4">
                        @if($konten->file_path)
                            <a href="{{ asset('storage/' . $konten->file_path) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-download mr-2"></i> Edit Materi
                            </a>
                            <a href="{{ asset('storage/' . $konten->video_path) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-file-video"></i> Hapus Materi
                            </a>
                        @else
                            <p class="text-muted">Tidak ada file</p>
                        @endif
                    </div>
                </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 text-center">
                <a href="{{ route('guru.konten') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
