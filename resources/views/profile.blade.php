@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profil Pengguna</h1>
        <p>Username: {{ Auth::user()->username }}</p>
        <p>Telepon: {{ Auth::user()->telepon }}</p>
        <!-- Tambahkan data lainnya sesuai kebutuhan -->
    </div>
@endsection
