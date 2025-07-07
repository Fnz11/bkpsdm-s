@extends('layouts.akpkLayouts.akpk')

@section('content')
    <section class="container">
        <div class="alert alert-warning text-center mt-5">
            <h4>{{ $message }}</h4>
        </div>
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </section>
@endsection
