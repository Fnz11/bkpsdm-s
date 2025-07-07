@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-3">Detail Atasan</h2>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>NIP</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->nip }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->nama }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pangkat/Golongan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->pangkat_golongan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->jabatan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Unit Kerja</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->unitkerja }}
                        </td>
                    </tr>
                    <tr>
                        <th>Jenis Pelatihan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->jenis_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->nama_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Penyelenggara</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->penyelenggara_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pelaksanaan Pelatihan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->pelaksanaan_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Biaya</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->biaya }}
                        </td>
                    </tr>
                    <tr>
                        <th>Laporan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatatasan->laporan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pelatihan</th>
                        <td>
                            {{ date('d-m-Y', strtotime($pelatihan_5_pascadiklatatasan->tanggal_pelatihan)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>
                            {{ date('d-m-Y', strtotime($pelatihan_5_pascadiklatatasan->selesai_pelatihan)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Hasil Pelatihan</th>
                        <td>
                            {{ ucfirst($pelatihan_5_pascadiklatatasan->hasil_pelatihan) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span
                                class="badge bg-{{ $pelatihan_5_pascadiklatatasan->Status_peserta == 'Atasan' ? 'success' : 'warning' }}">
                                {{ $pelatihan_5_pascadiklatatasan->Status_peserta }}
                            </span>
                        </td>
                    </tr>
                </table>

                <a href="{{ route('evaluasi.atasan') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection