@extends('layouts.menu')

@section('content')

    <h2>Dashboard rekan</h2>
    <p>Selamat datang, {{ session('user_name', 'Guest') }}!</p>

    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
