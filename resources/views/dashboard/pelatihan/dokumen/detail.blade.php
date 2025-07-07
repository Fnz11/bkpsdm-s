@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen')

@section('breadcrumb')
<ol class="breadcrumb mt-2">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.dokumen') }}">Dokumen</a></li>
    <li class="breadcrumb-item active">Detail</li>
</ol>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Nama Dokumen:</h5>
        <p>{{ $dokumen->nama_dokumen }}</p>

        <h5>NIP Admin:</h5>
        <p>{{ $dokumen->admin_nip }} - {{ $dokumen->admin->name }}</p>

        <h5>File:</h5>
        <p><a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">Lihat File</a></p>

        <h5>Tanggal Upload:</h5>
        <p>{{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->translatedFormat('d M Y H:i') }}</p>

        <h5>Keterangan:</h5>
        <p>{{ $dokumen->keterangan ?? '-' }}</p>

        <h5>Status:</h5>
        <p>{{ ucfirst($dokumen->status) }}</p>
    </div>
</div>
@endsection
