<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tugas Akhir dan Skripsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-maroon {
            background-color: #800000 !important;
        }
        .btn-maroon {
            background-color: #800000;
            color: white;
        }
        .btn-maroon:hover {
            background-color: #600000;
            color: white;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <div class="bg-maroon text-white py-3 mb-4 shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold fs-4">Sistem Tugas Akhir dan Skripsi</h2>
            
            <div class="d-flex align-items-center gap-3">
                @auth
                    <span class="fs-6">
                        Logged in: <strong>{{ Auth::user()->name }}</strong> 
                        <span class="badge bg-warning text-dark ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm fw-semibold px-3 py-1">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <div class="container flex-grow-1 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 text-dark fw-bold">Data Mahasiswa Peserta TA</h4>
                <p class="text-muted mb-0">Pengelolaan data mahasiswa yang mengikuti Tugas Akhir</p>
            </div>
            
            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-maroon">+ Tambah Mahasiswa</a>
            @endif
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>SKS Lulus</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswas as $index => $mhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->angkatan }}</td>
                            <td>{{ $mhs->sks }}</td>
                            <td>
                                @if($mhs->status == 'Aktif')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    @if(Auth::user()->role === 'admin')
                                        <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-auto bg-maroon text-white">
        <small>Nama: Nilna Mina Septiani | NIM: 102022500190 | Kelas: SI4906 | Kelompok: 11 | Modul: Modul Data Mahasiswa</small>
    </footer>

</body>
</html>