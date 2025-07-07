@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div style="margin-top: 100px; margin-left: 30px;"> <!-- Geser layout ke bawah dan kanan -->
        <h2 style="margin-bottom: 20px;">Dashboard</h2>
        <div>
            <!-- Kartu 1 -->
            <div style="background-color: #f0e7d2; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                <h3>Draft Katalog Masuk:</h3>
                <p style="font-size: 24px; font-weight: bold;">{{ $draftKatalog ?? 0 }}</p>
            </div>

            <!-- Kartu 2 -->
            <div style="background-color: #f0e7d2; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                <h3>Draft Laporan Masuk:</h3>
                <p style="font-size: 24px; font-weight: bold;">{{ $draftLaporan ?? 0 }}</p>
            </div>
        </div>
    </div>
@endsection
