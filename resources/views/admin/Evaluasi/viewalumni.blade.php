@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-3">Detail Alumni</h2>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>NIP</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->nip }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->nama }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pangkat/Golongan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->pangkat_golongan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->jabatan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Unit Kerja</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->unitkerja }}
                        </td>
                    </tr>
                    <tr>
                        <th>Jenis Pelatihan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->jenis_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->nama_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Penyelenggara</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->penyelenggara_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pelaksanaan Pelatihan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->pelaksanaan_pelatihan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Biaya</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->biaya }}
                        </td>
                    </tr>
                    <tr>
                        <th>Laporan</th>
                        <td>
                            {{ $pelatihan_5_pascadiklatalumni->laporan }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pelatihan</th>
                        <td>
                            {{ date('d-m-Y', strtotime($pelatihan_5_pascadiklatalumni->tanggal_pelatihan)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>
                            {{ date('d-m-Y', strtotime($pelatihan_5_pascadiklatalumni->selesai_pelatihan)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Hasil Pelatihan</th>
                        <td>
                            {{ ucfirst($pelatihan_5_pascadiklatalumni->hasil_pelatihan) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span
                                class="badge bg-{{ $pelatihan_5_pascadiklatalumni->Status_peserta == 'Alumni' ? 'success' : 'warning' }}">
                                {{ $pelatihan_5_pascadiklatalumni->Status_peserta }}
                            </span>
                        </td>
                    </tr>
                </table>

                <a href="{{ route('evaluasi.alumni') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection