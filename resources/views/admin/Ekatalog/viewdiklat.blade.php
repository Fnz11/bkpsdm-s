@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0 fw-bold">Data Diklat</h4>
                </div>

                <div class="card-body bg-light">
                    <table class="table table-bordered bg-white">
                        <tbody>
                            <tr>
                                <th>Rumpun Pelatihan</th>
                                <td>{{ $diklat->rumpun_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pelatihan</th>
                                <td>{{ $diklat->jenis_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pelatihan</th>
                                <td>{{ $diklat->nama_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Informasi Pelatihan</th>
                                <td>{{ $diklat->informasi_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Estimasi Biaya</th>
                                <td>Rp {{ number_format($diklat->estimasi_biaya, 0, ',', '.') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Penyelenggara</th>
                                <td>{{ $diklat->nama_penyelenggara ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama CP</th>
                                <td>{{ $diklat->nama_CP ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>{{ $diklat->no_HP ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pelatihan</th>
                                <td>{{ $diklat->metode_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pelaksanaan Pelatihan</th>
                                <td>{{ $diklat->pelaksanaan_pelatihan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($diklat->status == 'visible')
                                        <span class="badge bg-success">Visible</span>
                                    @else
                                        <span class="badge bg-danger">Hidden</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $diklat->keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>File Pelatihan</th>
                                <td>
                                    @if ($diklat->file_pelatihan)
                                        <a href="{{ asset('storage/' . $diklat->file_pelatihan) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-alt"></i> Lihat File
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-3">
                        <a href="{{ route('admin.ekatalog.diklat') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
