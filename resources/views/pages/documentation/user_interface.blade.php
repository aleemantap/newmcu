@extends('layouts.app')

@section('title', 'Documentation - User Interface')

@section('ribbon')
<ol class="breadcrumb">
    <li>Documentation</li>
    <li>User Interface</li>
</ol>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/css/documentation.css') }}">
@endsection

@section('content-class', 'documentation')

@section('content')
<h1>User Interface</h1>
<p>
    Komponen-komponen utama dalam aplikasi ini adalah <strong>panel atas</strong>, <strong>panel kiri</strong> dan <strong>konten</strong>. sebagaimana gambar berikut
</p>
<p><img class="img-fluid rounded" src="{{ asset('img/documentation/EMCU IHP Home.png') }}" alt="Komponen utama"></p>
<h2>Panel atas</h2>
<p>
    Di dalam panel atas, terdapat beberapa tombol dengan fungsi masing-masing, yaitu:
    <ol>
        <li><mark><i class="fa fa-reorder"></i> (Collapse Menu)</mark>, berfungsi untuk menyembunyikan atau menampilkan panel kiri</li>
        <li><mark><i class="fa fa-arrows-alt"></i> (Full Screen)</mark>, berfungsi untuk memasuki atau keluar dari mode layar penuh</li>
        <li><mark><i class="fa fa-bell"></i> (Sign Out)</mark>, berfungsi sebagai akses singkat untuk keluar dari aplikasi</li>
        <li><mark>Icon pengguna</mark>, memuat beberapa informasi nama dan alamat email pengguna. Di dalamnya juga terdapat beberapa fungsi yang berkenaan dengan profil pengguna, yaitu:
            <ul>
                <li><mark>Update profile</mark>, dapat digunakan untuk merubah foto profil, nama dan alamat email pengguna.</li>
                <li><mark>Change Password</mark>, untuk merubah password yang dapat digunakan untuk login.</li>
                <li><mark>Logout</mark>, untuk menutup akses dan keluar dari aplikasi</li>
            </ul>
        </li>
    </ol>
</p>
<h2>Panel kiri</h2>
<p>
    Panel kiri memuat menu yang dapat digunakan untuk mengakses halaman-halaman yang tersedia di dalam aplikasi ini. tanda <i class="fa fa-plus-square-o"></i> yang terdapat di sebelah kanan menu menandakan menu tersebut memiliki submenu di dalamnya.
</p>
<h2>Konten</h2>
<p>
    Bagian utama dalam setiap halaman yang diakses terletak pada bagian konten. Setiap halaman memiliki fitur masing-masing yang dibahas terpisah di dalam dokumentasi ini.
</p>
<p>
    Untuk konten dalam bentuk tabel, secara umum terdapat kolom <mark>action</mark> yang memuat fitur untuk memproses masing-masing data dalam tabel tersebut. fitur-fitur tersebut di antaranya ialah:
    <ul class="list-group">
        <li class="list-group-item"><button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button> berfungsi untuk menghapus salah satu data dalam tabel</li>
        <li class="list-group-item"><button class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button> berfungsi untuk merubah salah satu data dalam tabel</li>
        <li class="list-group-item"><button class="btn btn-default btn-xs"><i class="fa fa-gear"></i></button> berfungsi untuk melakukan penyesuaian terhadap salah satu data dalam tabel</li>
        <li class="list-group-item"><button class="btn btn-default btn-xs"><i class="fa fa-ban"></i></button> berfungsi untuk mengubah status salah satu data menjadi nonaktif</li>
        <li class="list-group-item"><button class="btn btn-default btn-xs"><i class="fa fa-check-circle"></i></button> berfungsi untuk mengubah status salah satu data menjadi aktif</li>
    </ul>
</p>
@endsection
