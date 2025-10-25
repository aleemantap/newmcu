<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resume Medical Check Up</title>
    <style>
        @page {
            size: A4;
            margin: 2cm 2cm 2.5cm 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.4;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-left img {
            width: 150px;
        }

        .header-right {
            font-size: 11px;
            line-height: 1.6;
        }

        .header-right table {
            border-collapse: collapse;
        }

        .header-right td:first-child {
            font-weight: bold;
            padding-right: 5px;
        }

        h1 {
            text-align: center;
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 10px;
        }

        .section b {
            display: inline-block;
            margin-bottom: 5px;
        }

        .diagnosis {
            margin-top: 15px;
        }

        .diagnosis-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .diagnosis-table td {
            vertical-align: top;
            padding: 5px 10px;
        }

        .diagnosis-table td:first-child {
            width: 30%;
            font-weight: bold;
        }

        .diagnosis-table td:nth-child(2) {
            width: 30%;
        }

        .diagnosis-table td:last-child {
            width: 40%;
        }

        .footer {
            position: fixed;
            bottom: 1cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #444;
        }

        .doctor {
            text-align: right;
            margin-top: 60px;
        }

        .doctor img {
            width: 120px;
            margin-bottom: 5px;
        }

        .doctor-name {
            font-weight: bold;
        }

        .clinic-info {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            line-height: 1.4;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('assets/images/logo-kiri-atas.png') }}" alt="Logo IHP">
        </div>
        <div class="header-right">
            <table>
                <tr><td>Medical ID #</td><td>{{ $mcu->medical_id ?? '-' }}</td></tr>
                <tr><td>Nama</td><td>{{ $mcu->nama ?? '-' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>{{ $mcu->jenis_kelamin ?? '-' }}</td></tr>
                <tr><td>Tgl Lahir</td><td>{{ optional($mcu->tgl_lahir)->format('d F Y') ?? '-' }}</td></tr>
                <tr><td>Id Pegawai</td><td>{{ $mcu->id_pegawai ?? '-' }}</td></tr>
                <tr><td>Bagian</td><td>{{ $mcu->bagian ?? '-' }}</td></tr>
                <tr><td>Perusahaan</td><td>{{ $mcu->perusahaan ?? '-' }}</td></tr>
                <tr><td>Paket MCU</td><td>{{ $mcu->paket_mcu ?? '-' }}</td></tr>
            </table>
        </div>
    </div>

    {{-- TITLE --}}
    <h1>RESUME MEDICAL CHECK UP</h1>

    {{-- DIAGNOSIS --}}
    <div class="section">
        <b>Diagnosis Kesehatan Kerja</b> : <strong>{{ strtoupper($mcu->diagnosis_kesehatan ?? 'FIT') }}</strong>
    </div>

    <div class="section">
        <b>Catatan</b><br>
        {{ $mcu->catatan ?? '-' }}
    </div>

    <div class="section">
        <b>Saran</b><br>
        {{ $mcu->saran ?? '-' }}
    </div>

    {{-- TABEL DIAGNOSIS --}}
    <div class="diagnosis">
        <b>Diagnosis Kerja</b>
        <table class="diagnosis-table">
            <tr>
                <td>Kategori Pemeriksaan</td>
                <td>ICD X</td>
                <td>Saran</td>
            </tr>
            <tr>
                <td>Pemeriksaan Fisik</td>
                <td>Obesity</td>
                <td>Diet rendah lemak, olahraga teratur, konsumsi buah dan sayur.</td>
            </tr>
            <tr>
                <td>Hematologi</td>
                <td>Iron deficiency anaemia</td>
                <td>Konsumsi multivitamin, buah dan sayuran, istirahat cukup.</td>
            </tr>
            <tr>
                <td>Pemeriksaan Fisik</td>
                <td>Hypertension</td>
                <td>Kontrol tekanan darah, diet rendah garam, kurangi stres.</td>
            </tr>
        </table>
    </div>

    {{-- DOKTER --}}
    <div class="doctor">
        <p><b>Dokter Pemeriksa Kesehatan Tenaga Kerja</b></p>
        <img src="{{ public_path('assets/images/ttd.png') }}" alt="Tanda Tangan Dokter">
        <div class="doctor-name">dr. Ade Budi Setiawan</div>
        <div>No Register PJK3 Kemenakertrans :<br>
            KEP.49/BINWSK3-PNK3/KK/II/2016</div>
    </div>

    {{-- FOOTER --}}
    <div class="clinic-info">
        Indonesia Health Protection<br>
        Kompleks Ruko Plaza Pasar Baru Blok B1 Jl. Moh Toha Pabuaran – Tangerang<br>
        Telp / Fax : 021 5576 6450<br>
        Email : health4community@plazamedis.com
    </div>
</body>
</html>
