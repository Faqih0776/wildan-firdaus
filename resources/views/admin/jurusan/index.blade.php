@extends('layout_new.app')

@section('konten')
<div class="container mt-3">
    <div class="card-body bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Daftar Jurusan</h2>
            <!-- Tombol untuk menambah jurusan -->
            <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-toggle="modal" data-target="#addJurusanModal">
                + Tambah Jurusan
            </button>
        </div>

    <!-- Card untuk tabel data -->
    <div class="card shadow-sm border-0 rounded">
        <div class="card-body">
            <!-- Tabel untuk data Jurusan -->
            <table class="table table-striped table-hover" id="basic-datatables">
                <thead class="bg-dark text-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurusan as $item)
                    <tr class="align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_jurusan }}</td>
                        <td>{{ $item->nama_jurusan }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-warning btn-sm rounded-pill" data-toggle="modal" data-target="#editJurusanModal-{{ $item->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <!-- Form Hapus -->
                            <form action="{{ route('admin.mapel.delete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit Jurusan -->
                    <div class="modal fade" id="editJurusanModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editJurusanModalLabel-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content rounded">
                                <div class="modal-header bg-light text-secondary">
                                    <h5 class="modal-title" id="editJurusanModalLabel-{{ $item->id }}">Edit Jurusan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.jurusan.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <label for="kode_jurusan">Kode Jurusan</label>
                                            <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan" value="{{ $item->kode_jurusan }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_jurusan">Nama Jurusan</label>
                                            <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="{{ $item->nama_jurusan }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
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
                <form id="addJurusanForm" action="{{ route('admin.jurusan.store') }}" method="POST">
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

@endsection
