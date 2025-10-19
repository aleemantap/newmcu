@extends('layouts.app')

@section('title', 'Documentation - Contents')

@section('ribbon')
<ol class="breadcrumb">
    <li>Documentation</li>
    <li>Contents</li>
</ol>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/css/documentation.css') }}">
@endsection

@section('content-class', 'documentation')

@section('content')
<h1>Konten</h1>
<p>Konten adalah bagian utama dalam setiap halaman, di dalamnya terdapat fitur-fitur yang bisa dimanfaatkan sesuai fungsinya masing-masing. Berikut penjelasan masing-masing fitur dalam setiap konten berdasarkan halaman yang tersedia:</p>

<h2>Customer</h2>
<p><img src="{{ asset('img/documentation/EMCU IHP Customer.png') }}" alt="Halaman Customer"></p>
<p>Di dalam halaman Customer, terdapat tabel customer bersama fitur-fitur yang dapat digunakan di dalamnya sebagai berikut:</p>

    <h3>Bidang pencarian</h3>
    <div class="raw"><div class="dataTables_filter"><label style="float:left"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control bg-white"></label></div></div>
    <p>Bidang ini dapat digunakan untuk mencari data yang terdapat di dalam tabel customer. Bidang pencarian ini memungkinkan pengguna melakukan pencarian di semua kolom, baik <mark>nama</mark>, <mark>alamat</mark>, <mark>kota</mark>, <mark>nomor telepon</mark> ataupun <mark>email</mark>.</p>

    <h3>Tombol download</h3>
    <div class="raw"><button type="button" class="btn btn-default"><i class="fa fa-download"></i></button></div>
    <p>Berfungsi untuk mendownload seluruh data Customer dalam format xlsx</p>

    <h3>Tombol tambah data</h3>
    <div class="raw"><button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</button></div>
    <p>Berfungsi untuk menambahkan data baru ke dalam tabel customer</p>

<h2>Database</h2>
<p><img src="{{ asset('img/documentation/EMCU IHP Database.png') }}" alt="Halaman Database"></p>
<p>Pada menu Database, terdapat beberapa submenu yang isi kontennya hampir serupa, yaitu terdiri dari tabel beserta fitur-fiturnya sebagai berikut:</p>

    <h3>Pembatas jumlah data</h3>
    <div class="raw"><div><div class="d-flex flex-row">Show <select class="form-control input-sm bg-white" style="width:60px; display:inline-block"><option value="15">15</option></select> entries</div></div></div>
    <p>Bidang ini berfungsi untuk membatasi jumlah data yang ditampilkan dalam tabel perhalaman. jumlah data yang ditampilkan sesuai dengan angka yang ditunjukkan di dalam bidang pilihan</p>

    <h3>Tombol filter</h3>
    <div class="raw"><button type="button" class="btn btn-default"><i class="fa fa-filter"></i></button></div>
    <p>Berfungsi untuk menampilkan pilihan filter data sesuai dengan isi tabel pada masing-masing halaman</p>

    <h3>Tombol upload</h3>
    <div class="raw"><button type="button" class="btn btn-default"><i class="fa fa-upload"></i></button></div>
    <p>Berfungsi untuk menampilkan dialog upload file sebagai berikut</p>
    <p><img src="{{ asset('/img/documentation/EMCU IHP Database Import Modal.png') }}" alt="Database upload modal"></p>
    <p>Upload data berfungsi untuk menambahkan data ke dalam tabel sesuai dengan masing-masing halaman secara masal melalui file berformat xlsx yang telah disiapkan.</p>
    <p>File yang dapat diupload pada dialog di atas adalah file dengan template yang sesuai dengan kebutuhan aplikasi. Pengguna dapat mendownload template tersebut melalui tautan yang tersedia pada dialog di atas.</p>
    <p>Untuk melakukan upload file, pengguna dapat mengklik tombol <mark>Browse...</mark> kemudian pilih file yang telah disiapkan. Setelah itu klik tombol <mark class="bg-primary" style="color:#fff"><i class="fa fa-check-circle"></i> @lang('general.submit')</mark> untuk menyelesaikan proses upload.</p>

    <h3>Tombol download</h3>
    <div class="raw"><button type="button" class="btn btn-default"><i class="fa fa-download"></i></button></div>
    <p>Tombol download digunakan untuk membuka dialog download yang berisi pilihan filter data yang akan didownload. Isi pilihan filter tersebut berbeda pada masing-masing halaman yang tersedia.</p>
    <p>Filter digunakan untuk membatasi jumlah data yang akan didownload, jumlah data yang terlalu besar dapat menyebabkan proses download gagal.</p>

    <h3>Tombol publish</h3>
    <div class="raw"><button type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Publish</button></div>
    <p>Tombol ini digunakan untuk membuka dialog publish yang menampilkan pilihan data untuk dipublish. Pengguna dapat memilih untuk mempublish semua data atau menentukan beberapa data untuk dipublish berdasarkan filter yang tersedia dalam dialog publish.</p>

    <h3>Tombol bulk delete</h3>
    <div class="raw"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('general.bulk_delete')</button></div>
    <p>Tombol bulk delete dapat digunakan untuk membuka dialog bulk delete yang berfungsi untuk memilih satu atau beberapa data untuk dihapus dari tabel.</p>

    <h3>Tombol add</h3>
    <div class="raw"><button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> @lang('general.add')</button></div>
    <p>Digunakan untuk menambahkan data ke dalam tabel berdasarkan masing-masing halaman. Pada umumnya, tombol add membuka dialog yang berisi bidang input sesuai tabel pada masing-masing halaman. Namun khusus untuk halaman <mark>Medical Check Up</mark>, tombol add akan mengarahkan pengguna ke halaman input khusus karena table <mark>Medical Check Up</mark> memiliki bidang input yang banyak.</p>
    <p><img src="{{ asset('img/documentation/EMCU IHP Database MCU Create.png') }}" alt="Database MCU create"></p>
    <p>Dalam halaman input data Medical Check Up di atas, terdapat tab-tab di bagian atas untuk melakukan navigasi antar sub halaman input. Navigasi juga dapat dilakukan dengan menekan tombol yang terdapat pada bagian bawah halaman. Tombol <mark><i class="fa fa-chevron-left"></i> Previous</mark> untuk menuju sub halaman sebelumnya, dan tombol <mark>Next <i class="fa fa-chevron-right"></i></mark> untuk menuju sub halaman berikutnya.</p>
    <p>Beberapa sub halaman dalam halaman input Medical Check Up memungkinkan input lebih dari satu data sebagaimana gambar berikut</p>
    <p><img src="{{ asset('img/documentation/EMCU IHP Database MCU Create Sub.png') }}" alt="Database MCU create sub"></p>
    <p>Pada sub halaman sebagaimana gambar di atas, pengguna dapat menambahkan bidang input dengan menekan tautan <mark class="text-success"><i class="fa fa-plus-circle"></i> @lang('general.add') Input</mark>. Pengguna juga dapat melakukan pengurangan terhadap bidang input dengan menekan tombol <mark class="bg-danger" style="color:#fff"> &nbsp; &nbsp; <i class="fa fa-trash"></i> &nbsp; &nbsp; </mark></p>

<h2>Report</h2>
<p><img src="{{ asset('img/documentation/EMCU IHP Report.png') }}" alt="Halaman Report"></p>
<p>Menu Report terdiri dari beberapa submenu yang isi kontennya hampir serupa, yaitu terdiri dari tabel beserta fitur-fiturnya sebagai berikut:</p>

    <h3>Menampilkan filter</h3>
    <p>Pengguna dapat menggunakan tautan <mark class="text-primary"><i class="fa fa-chevron-down"></i> Show Filter <i class="fa fa-filter"></i></mark> yang berganti menjadi <mark class="text-primary"><i class="fa fa-chevron-up"></i> Hide Filter <i class="fa fa-filter"></i></mark> saat diakses untuk menampilkan dan menyembunyikan pilihan filter yang dapat digunakan untuk menampilkan data atau mengunduhnya. Pilihan filter pada masing-masing halaman berbeda, namun secara garis besar, setiap halaman memiliki fitur filter yang sama.</p>
    <p><img src="{{ asset('img/documentation/EMCU IHP Report Filter.png') }}" alt="Halaman Report dengan filter"></p>
    <p>Pilihan filter yang tertera pada gambar di atas adalah pilihan filter untuk halaman Report Medical Check Up. Di dalamnya terdapat tombol <mark class="bg-primary" style="color:#fff"><i class="fa fa-check-circle"></i> @lang('general.submit')</mark> untuk menampilkan dan tombol <mark><i class="fa fa-download"></i> @lang('general.download')</mark> untuk mengunduh data sesuai dengan filter yang telah ditentukan. Kedua tombol tersebut juga terdapat pada pilihan filter untuk halaman-halaman report lainnya.</p>

    <h3>Pembatas jumlah data</h3>
    <div><div class="d-flex flex-row">Show <select class="form-control input-sm bg-white" style="width:60px; display:inline-block"><option value="15">15</option></select> entries</div></div>
    <p>Bidang ini berfungsi untuk membatasi jumlah data yang ditampilkan dalam tabel perhalaman. jumlah data yang ditampilkan sesuai dengan angka yang ditunjukkan di dalam bidang pilihan</p>
@endsection
