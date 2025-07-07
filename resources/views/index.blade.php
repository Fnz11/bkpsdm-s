@extends('layouts.app')

@section('content')
<div class="dashboard-content">
    <div class="draft-item">
        <span>Draft Katalog Masuk:</span>
        <span>{{ $data['draftKatalogMasuk'] }}</span>
    </div>
    <div class="draft-item">
        <span>Draft Laporan Masuk:</span>
        <span>{{ $data['draftLaporanMasuk'] }}</span>
    </div>
</div>
@endsection
