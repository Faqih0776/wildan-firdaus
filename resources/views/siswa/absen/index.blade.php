@extends('layout2.app')

@section('konten')
<title>Absen Masuk</title>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h3>Absen Masuk</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.absen.store') }}" method="POST">
                @csrf
                <div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    {{-- <div class="mb-3">
                    <label for="user_id" class="form-label">Siswa</label>
                    <select name="user_id" class="form-control" required>
                        <option selected disabled>-- Pilih Nama --</option>
                        @foreach ($users as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                        @endforeach
                    </select>
                </div> --}}
                </div>

                <button type="submit" class="btn btn-primary">Absen Masuk</button>
            </form>
        </div>
    </div>
</div>
<div class="container mt-5">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h3 class="font-weight-bold">Absensi Hari Ini</h3>
    </div>

    <!-- Tabel Ujian -->
    <div class="card shadow">
    @forelse ($absensi as $data)
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Absensi</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0">
                <thead class="bg-dark text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Absen</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data->user->username }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal_absen)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                @if ($data->status === 'sakit')
                                    Sakit
                                @else
                                    {{ $data->jam_masuk ?? 'Belum Absen Masuk' }}
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $data->status }}
                            </td>
                            <td class="text-center">
                                {{ $data->note ?? '-' }}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    @empty
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0" style="text-align: center;">Anda Belum Melakakukan Absensi Hari Ini</h5>
        </div>
    @endforelse
    </div>
</div>
@endsection
