@extends('layouts.app')

@section('title', 'Documentation - User Management')

@section('ribbon')
<ol class="breadcrumb">
    <li>Documentation</li>
    <li>User Management</li>
</ol>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/css/documentation.css') }}">
@endsection

@section('content-class', 'documentation')

@section('content')
<h1>Manajemen Pengguna</h1>
<p>Menu <mark>User Management</mark> memiliki tiga submenu di dalamnya: <mark>User</mark>, <mark>User Group</mark> dan <mark>Menu</mark></p>

<h2>User</h2>
<p><img src="{{ asset('img/documentation/EMCU IHP User.png') }}" alt="Halaman User"></p>
<p>Halaman <mark>User</mark> memuat tabel pengguna dengan fitur-fiturnya sebagai berikut:</p>

    <h3>Bidang pencarian</h3>
    <div class="raw"><div class="dataTables_filter"><label style="float:left"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control bg-white"></label></div></div>
    <p>Bidang ini dapat digunakan untuk mencari data yang terdapat di dalam tabel pengguna. Bidang pencarian ini memungkinkan pengguna melakukan pencarian untuk kolom <mark>Name</mark>, <mark>Email</mark>, <mark>Group</mark>, dan <mark>Customer</mark>.</p>

    <h3>Tombol New User</h3>
    <div class="raw"><button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> New User</button></div>
    <p>Tombol <mark>New User</mark> dapat digunakan untuk menampilkan dialog yang berisi bidang-bidang input yang dibutuhkan untuk menambahkan pengguna baru sebagaimana gambar berikut</p>
    <p><img src="{{ asset('img/documentation/EMCU IHP User Create Modal.png') }}" alt="Dialog penambahan pengguna baru"></p>

<h2>User Group</h2>
<p><img src="{{ asset('img/documentation/EMCU IHP User Group.png') }}" alt="Halaman User Group"></p>
<p>Halaman <mark>User Group</mark> memiliki fitur yang hampir sama dengan halaman <mark>User</mark>. Di dalam halaman <mark>User Group</mark> juga terdapat bidang pencarian dan tombol yang berfungsi untuk menambahkan data yaitu tombol <mark class="bg-primary text-light"><i class="fa fa-check-circle"></i> New User Group</mark>. Dialog yang muncul saat tombol <mark>New User Group</mark> diakses adalah sebagaimana gambar berikut</p>
<p><img src="{{ asset('img/documentation/EMCU IHP User Group Create Modal.png')}}" alt="Dialog penambahan user group"></p>
<p>Pada tabel <mark>User Group</mark> pada halaman ini, terdapat tombol <mark class="btn btn-default btn-xs"><i class="fa fa-gear"></i></mark> pada masing-masing data yang berfungsi untuk menyesuaikan hak akses kelompok pengguna tertentu terhadap halaman-halaman yang tersedia. Berikut tampilan dialog saat tombol tersebut diakses</p>
<p><img src="{{ asset('img/documentation/EMCU IHP User Group Privilege Modal.png')}}" alt="Dialog penambahan user group"></p>

<h2>Menu</h2>
<p><img src="{{ asset('img/documentation/EMCU IHP Menu Builder.png')}}" alt="Halaman Menu"></p>
<p>Halaman <mark>Menu</mark> memuat nama-nama menu yang tersedia. dalam halaman ini, pengguna dapat melakukan penyusunan ulang terhadap menu-menu yang tersedia dengan cara menggeser menu yang diinginkan ke atas atau ke bawah sesuai kebutuhan. Pengguna juga dapat menggeser nama menu ke kanan untuk menjadikannya submenu dari menu yang ada di atasnya, atau menggeser nama menu ke kiri untuk mengeluarkan menu tersebut dari menu yang ada di atasnya. Setelah semua menu tersusun sesuai kebutuhan, pengguna harus mengklik tombol <mark><i class="fa fa-check-circle"></i> Update</mark> untuk mendaftarkannya ke dalam database.</p>

<p>Selain itu, pengguna juga dapat menambahkan menu baru dengan mengklik tombol <mark class="bg-primary text-light"><i class="fa fa-plus-circle"></i> @lang('general.add') New Menu</mark>. Tombol tersebut berfungsi untuk memunculkan dialog penambahan menu baru sebagaimana gambar berikut</p>
<p><img src="{{ asset('img/documentation/EMCU IHP Menu Builder Create Modal.png')}}" alt="Dialog penambahan menu"></p>
<p>
    Dalam dialog tersebut terdapat beberapa bidang yang dapat diisi, diantaranya sebagai berikut:
    <ul>
        <li><mark>Name</mark>, diisi dengan nama menu baru yang akan ditambahkan</li>
        <li><mark>Tooltip</mark>, diisi dengan keterangan yang akan muncul saat nama menu tersebut dilewati kursor.</li>
        <li><mark>Description</mark>, diisi dengan keterangan fungsi atau isi dari menu yang akan dibuat.</li>
        <li><mark>Icon (HTML)</mark>, diisi dengan kode HTML yang merepresentasikan simbol icon, misalnya kode class dari style Font Awesome.</li>
        <li><mark>URL</mark>, diisi dengan URL menuju halaman yang akan diakses saat menu tersebut diklik.</li>
        <li><mark>Actions</mark>, berisi beberapa pilihan perilaku yang dapat dilakukan pengguna saat berada di dalam halaman dengan nama menu yang akan dibuat.</li>
    </ul>
</p>
@endsection
