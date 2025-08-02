<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Pengamatan</title>
    <style>
    @page {
        size: A4 landscape;
        margin: 0;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 10px;
    }

    .container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }

    .header {
        text-align: center;
        margin-bottom: 15px;
    }

    .header h2 {
        margin: 5px 0;
        font-size: 16px;
    }

    .header p {
        margin: 3px 0;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        table-layout: fixed;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 3px;
        text-align: center;
        word-wrap: break-word;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .text-left {
        text-align: left;
    }

    .no-border {
        border: none;
    }

    /* Improved Footer Styling */
    .footer-section {
        margin-top: 30px;
        width: 100%;
    }

    .signature-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .signature-table td {
        border: none;
        padding: 8px;
        vertical-align: top;
        text-align: center;
    }

    .date-location {
        text-align: right;
        margin-bottom: 20px;
        font-size: 11px;
        font-weight: normal;
    }

    .signature-title {
        font-weight: bold;
        margin-bottom: 50px;
        font-size: 11px;
    }

    .signature-name {
        text-decoration: underline;
        font-weight: bold;
        margin-bottom: 2px;
        font-size: 11px;
    }

    .signature-rank {
        font-size: 10px;
        margin: 0;
    }

    .left-signature {
        width: 30%;
        text-align: center;
    }

    .center-signature {
        width: 40%;
        text-align: center;
    }

    .right-signature {
        width: 30%;
        text-align: center;
    }

    .page-break {
        page-break-after: always;
    }

    @media print {
        body {
            padding: 0;
        }

        .no-print {
            display: none;
        }

        table {
            font-size: 8px;
        }

        .header h2 {
            font-size: 14px;
        }

        .header p {
            font-size: 10px;
        }

        .signature-table {
            font-size: 9px;
        }

        .date-location {
            font-size: 9px;
        }
    }

    @media print {
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        body {
            padding: 0;
            margin: 0;
            font-size: 10px;
        }

        .no-print {
            display: none !important;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>LEMBAR PENILAIAN PENGAMATAN HARIAN</h2>
            <p>SEKOLAH KECABANGAN {{ strtoupper($tugasPeleton->ton_ki_yon ?? '') }}</p>
            <p>MINGGU KE {{ $tugasPeleton->minggu_ke ?? '' }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="3">NO</th>
                    <th rowspan="3">NAMA</th>
                    <th rowspan="3">NOSIS</th>
                    <th colspan="3">ASPEK MENTAL SPIRITUAL</th>
                    <th colspan="3">ASPEK MENTAL IDEOLOGI</th>
                    <th colspan="4">ASPEK MENTAL KEJUANGAN</th>
                    <th colspan="4">ASPEK WATAK PRIBADI</th>
                    <th colspan="8">ASPEK MENTAL KEPEMIMPINAN</th>
                    <th rowspan="3">JUMLAH INDIKATOR</th>
                    <th rowspan="3">SKOR</th>
                    <th rowspan="3">NILAI KONVERSI</th>
                    <th colspan="2">PELANGGARAN/PRESTASI</th>
                    <th rowspan="3">NILAI AKHIR</th>
                    <th rowspan="3">RANK HARIAN</th>
                </tr>
                <tr>
                    <th rowspan="2">1</th>
                    <th rowspan="2">2</th>
                    <th rowspan="2">3</th>
                    <th rowspan="2">1</th>
                    <th rowspan="2">2</th>
                    <th rowspan="2">3</th>
                    <th rowspan="2">1</th>
                    <th rowspan="2">2</th>
                    <th rowspan="2">3</th>
                    <th rowspan="2">4</th>
                    <th rowspan="2">1</th>
                    <th rowspan="2">2</th>
                    <th rowspan="2">3</th>
                    <th rowspan="2">4</th>
                    <th rowspan="2">1</th>
                    <th rowspan="2">2</th>
                    <th rowspan="2">3</th>
                    <th rowspan="2">4</th>
                    <th rowspan="2">5</th>
                    <th rowspan="2">6</th>
                    <th rowspan="2">7</th>
                    <th rowspan="2">8</th>
                    <th rowspan="2">-</th>
                    <th rowspan="2">+</th>
                </tr>
                <tr>
                    <!-- Empty row for numbering -->
                </tr>
            </thead>
            <tbody>
                @foreach($tugasSiswa as $index => $siswa)
                @if($siswa->penilaianPengamatan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $siswa->siswa->nama }}</td>
                    <td class="text-left">{{ $siswa->siswa->nosis }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_spiritual_1 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_spiritual_2 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_spiritual_3 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_ideologi_1 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_ideologi_2 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_ideologi_3 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kejuangan_1 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kejuangan_2 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kejuangan_3 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kejuangan_4 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->watak_pribadi_1 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->watak_pribadi_2 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->watak_pribadi_3 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->watak_pribadi_4 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_1 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_2 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_3 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_4 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_5 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_6 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_7 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->mental_kepemimpinan_8 }}</td>
                    <td>{{ $siswa->penilaianPengamatan->jumlah_indikator }}</td>
                    <td>{{ $siswa->penilaianPengamatan->skor }}</td>
                    <td>{{ $siswa->penilaianPengamatan->nilai_konversi }}</td>
                    <td>{{ $siswa->penilaianPengamatan->pelanggaran_prestasi_minus }}</td>
                    <td>{{ $siswa->penilaianPengamatan->pelanggaran_prestasi_plus }}</td>
                    <td>{{ $siswa->penilaianPengamatan->nilai_akhir }}</td>
                    <td>{{ $siswa->penilaianPengamatan->rank_harian }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <!-- Improved Footer Section -->
        <div class="footer-section">
            <div class="date-location">
                PADANG, 16 DESEMBER 2024
            </div>

            <table class="signature-table">
                <tr>
                    <td class="left-signature">
                        <div class="signature-title">DANUS PENGASUH</div>
                        <div style="height: 60px;"></div>
                        <div class="signature-name">WIDODO S.</div>
                        <div class="signature-rank">IPTU NRP 85040033</div>
                    </td>
                    <td class="center-signature">
                        <div class="signature-title">DANMEN PENGASUH SISWA DIKTUKBA POLRI GEL II TA 2024</div>
                        <div style="height: 60px;"></div>
                        <div class="signature-name">FIRDAUS, S.H., M.H.</div>
                        <div class="signature-rank">KOMPOL NRP 74070897</div>
                    </td>
                    <td class="right-signature">
                        <div class="signature-title">TAMTIKI EDI PUTRA</div>
                        <div style="height: 60px;"></div>
                        <div class="signature-name">(_______________________)</div>
                        <div class="signature-rank">IPDA NRP 77040304</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>