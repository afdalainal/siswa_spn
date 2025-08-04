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
        padding: 5mm;
        font-size: 8px;
    }

    .container {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .page-break {
        page-break-before: always;
    }

    .header {
        text-align: center;
        margin-bottom: 5px;
    }

    .header h2 {
        margin: 2px 0;
        font-size: 12px;
    }

    .header p {
        margin: 2px 0;
        font-size: 9px;
    }

    .header-title {
        font-weight: bold;
        margin-bottom: 3px;
    }

    .header-subtitle {
        font-weight: bold;
        margin-top: 8px;
        margin-bottom: 3px;
    }

    .header-info {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 8px;
    }

    .header-info td {
        vertical-align: top;
        padding: 0;
    }

    .header-info-left {
        text-align: left;
        width: 25%;
    }

    .header-info-center {
        text-align: center;
        width: 35%;
    }

    .header-info-right {
        text-align: right;
        width: 40%;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 7px;
        table-layout: fixed;
        page-break-inside: auto;
        border: 1px solid #000;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #000;
        padding: 2px;
        text-align: center;
        vertical-align: middle;
    }

    .data-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    /* EXPLICITLY SET RIGHT BORDER FOR LAST COLUMN */
    .data-table tr th:last-child,
    .data-table tr td:last-child {
        border-right: 1px solid #000 !important;
    }

    .text-left {
        text-align: left;
    }

    .nowrap {
        white-space: nowrap;
    }

    /* Column width adjustments */
    .no-col {
        width: 3%;
    }

    .nama-col {
        width: 12%;
        min-width: 80px;
    }

    .nosis-col {
        width: 8%;
        min-width: 60px;
    }

    .indikator-col {
        width: 2.5%;
    }

    .score-col {
        width: 3.5%;
    }

    .pelanggaran-col {
        width: 2.5%;
    }

    .rank-col {
        width: 3.5%;
    }

    .header-col {
        padding: 1px;
        font-size: 6px;
        line-height: 1.1;
    }

    .footer-section {
        margin-top: 10px;
        width: 100%;
    }

    .signature-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8px;
    }

    .signature-table td {
        border: none;
        padding: 3px;
        vertical-align: top;
        text-align: center;
    }

    .date-location {
        text-align: right;
        margin-bottom: 10px;
        font-size: 8px;
    }

    .signature-title {
        font-weight: bold;
        margin-bottom: 30px;
        font-size: 8px;
    }

    .signature-name {
        text-decoration: underline;
        font-weight: bold;
        margin-bottom: 1px;
        font-size: 8px;
    }

    .signature-rank {
        font-size: 7px;
        margin: 0;
    }

    @media print {
        body {
            padding: 0;
            margin: 0;
        }

        .container {
            padding: 2mm;
        }

        .data-table {
            font-size: 6.5px;
        }

        .data-table th,
        .data-table td {
            padding: 1px;
        }

        .header h2 {
            font-size: 11px;
        }

        .header p {
            font-size: 8px;
        }

        .signature-table {
            font-size: 7px;
        }

        .date-location {
            font-size: 7px;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }
    }
    </style>
</head>

<body>
    @for ($hari = 1; $hari <= 7; $hari++) @if ($hari> 1)
        <div class="page-break"></div>
        @endif

        <div class="container">
            <div class="header">
                <p class="header-title">KEPOLISIAN NEGARA REPUBLIK INDONESIA</p>
                <p class="header-title">DAERAH SUMATERA BARAT</p>
                <p class="header-title">SEKOLAH POLISI NEGARA</p>

                <p class="header-subtitle">DAFTAR NILAI MENTAL HASIL PENGAMATAN HARIAN</p>
                <p>SISWA DIKTUK BINTARA POLRI ANGKATAN. LI GEL II T.A 2024 SPN POLDA SUMBAR</p>

                <table class="header-info">
                    <tr>
                        <td class="header-info-left">
                            TON / KI / YON : {{ strtoupper($tugasPeleton->ton_ki_yon ?? '') }}
                        </td>
                        <td class="header-info-center">
                            MINGGU KE : {{ $tugasPeleton->minggu_ke ?? '' }}
                        </td>
                        <td class="header-info-right">
                            HARI/TGL :
                            @php
                            $hariTglField = 'hari_tgl_' . $hari;
                            $hariTglValue = $tugasPeleton->{$hariTglField} ?? '';
                            echo strtoupper($hariTglValue);
                            @endphp
                        </td>
                    </tr>
                </table>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th class="no-col" rowspan="3">NO</th>
                        <th class="nama-col" rowspan="3">NAMA</th>
                        <th class="nosis-col" rowspan="3">NOSIS</th>
                        <th colspan="3">MENTAL<br>SPIRITUAL</th>
                        <th colspan="3">MENTAL<br>IDEOLOGI</th>
                        <th colspan="4">MENTAL<br>KEJUANGAN</th>
                        <th colspan="4">WATAK<br>PRIBADI</th>
                        <th colspan="8">MENTAL<br>KEPEMIMPINAN</th>
                        <th class="score-col" rowspan="3">JUMLAH<br>INDIKATOR</th>
                        <th class="score-col" rowspan="3">SKOR</th>
                        <th class="score-col" rowspan="3">NILAI<br>KONVERSI</th>
                        <th colspan="2">PELANGGARAN/<br>PRESTASI</th>
                        <th class="score-col" rowspan="3">NILAI<br>AKHIR</th>
                        <th class="rank-col" rowspan="3">RANK<br>HARIAN</th>
                    </tr>
                    <tr>
                        <th class="header-col" rowspan="2">1</th>
                        <th class="header-col" rowspan="2">2</th>
                        <th class="header-col" rowspan="2">3</th>
                        <th class="header-col" rowspan="2">1</th>
                        <th class="header-col" rowspan="2">2</th>
                        <th class="header-col" rowspan="2">3</th>
                        <th class="header-col" rowspan="2">1</th>
                        <th class="header-col" rowspan="2">2</th>
                        <th class="header-col" rowspan="2">3</th>
                        <th class="header-col" rowspan="2">4</th>
                        <th class="header-col" rowspan="2">1</th>
                        <th class="header-col" rowspan="2">2</th>
                        <th class="header-col" rowspan="2">3</th>
                        <th class="header-col" rowspan="2">4</th>
                        <th class="header-col" rowspan="2">1</th>
                        <th class="header-col" rowspan="2">2</th>
                        <th class="header-col" rowspan="2">3</th>
                        <th class="header-col" rowspan="2">4</th>
                        <th class="header-col" rowspan="2">5</th>
                        <th class="header-col" rowspan="2">6</th>
                        <th class="header-col" rowspan="2">7</th>
                        <th class="header-col" rowspan="2">8</th>
                        <th class="pelanggaran-col header-col" rowspan="2">-</th>
                        <th class="pelanggaran-col header-col" rowspan="2">+</th>
                    </tr>
                    <tr>
                        <!-- Empty row for numbering -->
                    </tr>
                </thead>
                <tbody>
                    @if(isset($dataHarian[$hari]) && count($dataHarian[$hari]) > 0)
                    @foreach($dataHarian[$hari] as $index => $siswaData)
                    <tr>
                        <td class="no-col">{{ $index + 1 }}</td>
                        <td class="text-left nama-col nowrap">{{ $siswaData['siswa']->nama }}</td>
                        <td class="text-left nosis-col nowrap">{{ $siswaData['siswa']->nosis }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_spiritual_1 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_spiritual_2 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_spiritual_3 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_ideologi_1 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_ideologi_2 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_ideologi_3 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kejuangan_1 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kejuangan_2 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kejuangan_3 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kejuangan_4 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->watak_pribadi_1 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->watak_pribadi_2 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->watak_pribadi_3 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->watak_pribadi_4 ?? '-' }}</td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_1 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_2 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_3 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_4 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_5 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_6 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_7 ?? '-' }}
                        </td>
                        <td class="indikator-col">{{ $siswaData['penilaianPengamatan']->mental_kepemimpinan_8 ?? '-' }}
                        </td>
                        <td class="score-col">{{ $siswaData['penilaianPengamatan']->jumlah_indikator ?? '-' }}</td>
                        <td class="score-col">{{ $siswaData['penilaianPengamatan']->skor ?? '-' }}</td>
                        <td class="score-col">{{ $siswaData['penilaianPengamatan']->nilai_konversi ?? '-' }}</td>
                        <td class="pelanggaran-col">
                            {{ $siswaData['penilaianPengamatan']->pelanggaran_prestasi_minus ?? '-' }}</td>
                        <td class="pelanggaran-col">
                            {{ $siswaData['penilaianPengamatan']->pelanggaran_prestasi_plus ?? '-' }}</td>
                        <td class="score-col">{{ $siswaData['penilaianPengamatan']->nilai_akhir ?? '-' }}</td>
                        <td class="rank-col">{{ $siswaData['penilaianPengamatan']->rank_harian ?? '-' }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="31" style="text-align: center; padding: 20px;">
                            Tidak ada data penilaian untuk hari ke-{{ $hari }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Footer Section -->
            <div class="footer-section">
                <div class="date-location">
                    PADANG,
                    @php
                    $hariTglField = 'hari_tgl_' . $hari;
                    $hariTglValue = $tugasPeleton->{$hariTglField} ?? '';
                    echo strtoupper($hariTglValue);
                    @endphp
                </div>

                <table class="signature-table">
                    <tr>
                        <td style="width: 25%;">
                            <div class="signature-title">DANKI PENGASUH</div>
                            <div style="height: 30px;"></div>
                            <div class="signature-name">{{ $tugasPeleton->pengasuhDanki->nama ?? '' }}</div>
                            <div class="signature-rank">{{ $tugasPeleton->pengasuhDanki->pangkat_nrp ?? '' }}</div>
                        </td>
                        <td style="width: 35%;">
                            <div class="signature-title">DANMEN PENGASUH SISWA DIKTUKBA POLRI GEL II TA 2024</div>
                            <div style="height: 30px;"></div>
                            <div class="signature-name">{{ $tugasPeleton->pengasuhDanmen->nama ?? '' }}</div>
                            <div class="signature-rank">{{ $tugasPeleton->pengasuhDanmen->pangkat_nrp ?? '' }}</div>
                        </td>
                        <td style="width: 40%;">
                            <div class="signature-title">DANTON PENGASUH</div>
                            <div style="height: 30px;"></div>
                            <div class="signature-name">{{ $tugasPeleton->pengasuhDanton->nama ?? '' }}</div>
                            <div class="signature-rank">{{ $tugasPeleton->pengasuhDanton->pangkat_nrp ?? '' }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endfor
</body>

</html>