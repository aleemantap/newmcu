<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan MCU #{{ $mcu->id }}</title>
    <style>
        @page { margin: 40px 30px; }
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; color: #333; }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .header img {
            height: 60px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #aaa;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
       <img src="{{ asset('assets/images/logo-kiri-atas.png') }}" alt="Logo">
        <h1>Laporan MCU</h1>
        <p>ID Pemeriksaan: {{ $mcu->id }}</p>
       
    </div>

    <table>
        <thead>
            <tr>
                <th>Jenis Pemeriksaan</th>
                <th>Hasil</th>
                <th>Catatan Dokter</th>
            </tr>
        </thead>
        <tbody>
       
        </tbody>
    </table>

    <footer>
        Dicetak otomatis oleh sistem pada 
    </footer>
</body>
</html>
