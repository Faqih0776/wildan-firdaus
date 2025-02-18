@extends('layout2.app')

@section('konten')
<title>Lihat Konten Belajar</title>
<div>
    <h3 style="font-size: 40px; font-weight: bold; color: black;">Ruang Proyek</h3>
    <div class="card shadow-lg">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 style="font-size: 15px; font-weight: bold;"><i class="fas fa-list"></i> Konten Belajar</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div >
                        {{-- Tampilan Video --}}
                        <div >
                            <div >
                                <div >
                                    @if($konten->link_youtube)
                                        <!-- Parsing YouTube ID -->
                                        @php
                                            parse_str(parse_url($konten->link_youtube, PHP_URL_QUERY), $ytParams);
                                            $youtubeId = $ytParams['v'] ?? null;
                                        @endphp
                                        @if($youtubeId)
                                            <iframe style="width: 100%; height: 390px;" src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen></iframe>
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

                    <div>
                        @if($konten->file_path)
                            <a href="{{ asset('storage/' . $konten->file_path) }}" target="_blank" class="btn btn-outline-primary">
                                Lihat E-Book
                            </a>
                            <a href="{{ asset('storage/' . $konten->video_path) }}" target="_blank" class="btn btn-outline-primary">
                                Lihat Video
                            </a>
                        @else
                            <p class="text-muted">Tidak ada file</p>
                        @endif
                    </div>
                    <hr style="border-top: 3px solid rgb(0, 0, 0);">
                    <div>
                        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#editMateriModal{{ $konten->id }}">
                            Edit Materi
                        </button>
                        <form action="{{ route('guru.konten.destroyYoutube', $konten->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-primary" style="border-color: #f44336; color: red;" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                Hapus Materi
                            </button>
                        </form>
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
                <!-- Modal Edit Materi -->
                <div class="modal fade" id="editMateriModal{{ $konten->id }}" tabindex="-1" role="dialog" aria-labelledby="editMateriModalLabel{{ $konten->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMateriModalLabel{{ $konten->id }}">Edit Materi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('guru.konten.updateLocal', $konten->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="judul">Judul Modul / Materi</label>
                                        <input type="text" name="judul" class="form-control" value="{{ $konten->judul }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <input type="text" name="deskripsi" class="form-control" value="{{ $konten->deskripsi }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mapel_id">Mata Pelajaran</label>
                                        <select name="mapel_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                            @foreach($mapel as $mapels)
                                                <option value="{{ $mapels->id }}" {{ $konten->mapel_id == $mapels->id ? 'selected' : '' }}>{{ $mapels->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kelas_id">Kelas</label>
                                        <select name="kelas_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Kelas</option>
                                            @foreach($kelas as $kelass)
                                                <option value="{{ $kelass->id }}" {{ $konten->kelas_id == $kelass->id ? 'selected' : '' }}>{{ $kelass->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File Materi</label>
                                        <input type="file" name="file" class="form-control-file">
                                        <small>Upload file jika ingin mengganti</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="link_youtube" class="form-label"><b>Link YouTube</b></label>
                                        <input type="url" class="form-control" id="link_youtube" name="link_youtube" value="{{ $konten->link_youtube }}" required>>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
@endsection
