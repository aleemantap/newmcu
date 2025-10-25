<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Resume Medical Check Up</title>
<style>
  @page {
    size: A4;
    margin: 2.5cm 2cm 3cm 2cm;
    @top-center {
      content: element(header);
    }
    @bottom-center {
      content: element(footer);
    }
  }

  body {
    font-family: Arial, sans-serif;
    font-size: 11pt;
    line-height: 1.4;
    color: #000;
  }

  /* Header yang akan muncul di semua halaman */
  header {
    position: running(header);
    text-align: left;
    margin-bottom: 20px;
  }

  header img {
    width: 200px;
  }

  /* Footer */
  footer {
    position: running(footer);
    font-size: 9pt;
    text-align: center;
    border-top: 1px solid #aaa;
    padding-top: 5px;
    margin-top: 20px;
  }

  .title {
    text-align: center;
    font-weight: bold;
    font-size: 14pt;
    margin-top: 20px;
    margin-bottom: 30px;
  }

  .section {
    margin-bottom: 20px;
  }

  .label {
    font-weight: bold;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }

  th, td {
    text-align: left;
    vertical-align: top;
    padding: 4px 6px;
  }

  th {
    font-weight: bold;
    border-bottom: 1px solid #ccc;
  }

  .page-break {
    page-break-before: always;
  }
</style>
</head>
<body>

<header>
  <img src="atas.png" alt="Header Logo">
</header>

<footer>
  <img src="bawah.png" alt="Footer Logo"><br>
  Indonesia Health Protection<br>
  Komplek Ruko Plaza Pasar Baru Blok B1 Jl. Moh Toha Pabuaran – Tangerang<br>
  Telp/Fax: 021 5576 6450 | Email: health4community@plazamedis.com
</footer>

<div class="title">RESUME MEDICAL CHECK UP</div>

<div class="section">
  <p><span class="label">Diagnosis Kesehatan Kerja:</span> FIT WITH RESTRICTION</p>
  <p><span class="label">Catatan:</span> Hb kurang dari 10</p>
  <p><span class="label">Saran:</span> Jaga pola hidup sehat, konsumsi makanan bergizi, istirahat cukup, olahraga teratur, hindari stres, tidak merokok, dan beribadah mendekatkan diri kepada-Nya.</p>
</div>

<div class="section">
  <table>
    <tr>
      <th>Kategori Pemeriksaan</th>
      <th>ICD X</th>
      <th>Saran</th>
    </tr>
    <tr>
      <td>Pemeriksaan Fisik</td>
      <td>Obesity</td>
      <td>Diet rendah lemak, olahraga teratur, konsumsi buah & sayur.</td>
    </tr>
    <tr>
      <td>Hematologi</td>
      <td>Iron deficiency anaemia</td>
      <td>Konsumsi multivitamin dan istirahat cukup.</td>
    </tr>
    <tr>
      <td>Pemeriksaan Fisik</td>
      <td>Hypertension</td>
      <td>Kontrol tekanan darah, kurangi stres, diet rendah garam.</td>
    </tr>
  </table>
</div>

<div class="page-break"></div>

<div class="section">
  <h3>Halaman 2 - Data Tambahan</h3>
  <p>Data tambahan atau tabel panjang bisa ditulis di sini. WeasyPrint otomatis akan melanjutkan layout ke halaman berikutnya tanpa memotong tabel di tengah baris.</p>

  <table>
    <tr><th>No</th><th>Pemeriksaan</th><th>Hasil</th></tr>
   @for ($i = 1; $i <= 10; $i++)
    <tr><td>{{ $i }}</td></tr>
@endfor
  </table>
</div>

</body>
</html>
