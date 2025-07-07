@extends('layouts.Pelatihan.pelatihan-dashboard')

@section('title', 'Usulkan Nama Pelatihan')

@section('page-title', 'Usulkan Nama Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.nomenklatur') }}">Nomenklatur</a></li>
        <li class="breadcrumb-item active">Usul Nomenklatur</li>
    </ol>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('dashboard.pelatihan.nomenklatur.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="kode_namapelatihan">Kode Nama Pelatihan</label>
                <input type="text" name="kode_namapelatihan" id="kode_namapelatihan" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="nama_pelatihan">Nama Pelatihan</label>
                <input type="text" name="nama_pelatihan" id="nama_pelatihan" class="form-control" required>
            </div>

            <input type="hidden" name="nip" value="{{ auth()->user()->nip }}">
            <input type="hidden" name="status" value="proses">

            <button type="submit" class="btn btn-primary">Usulkan</button>
        </form>
    </div>
</div>
@endsection

@section('additional-css')
@endsection

@section('scripts')
@endsection
