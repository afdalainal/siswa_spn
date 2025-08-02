<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Harian</title>
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

    .hari-col {
        width: 5%;
    }

    .rata-col {
        width: 5%;
    }

    .keterangan-col {
        width: 15%;
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

    .highlight {
        background-color: #ffff99;
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
    <div class="container">
        <div class="header">
            <p class="header-title">KEPOLISIAN NEGARA REPUBLIK INDONESIA</p>
            <p class="header-title">DAERAH SUMATERA BARAT</p>
            <p class="header-title">SEKOLAH POLISI NEGARA</p>

            <p class="header-subtitle">REKAPITULASI HASIL PENILAIAN MENTAL ( HARIAN )</p>
            <p>DARI {{ $tugasPeleton->hari_tgl_1 ?? '' }} s/d {{ $tugasPeleton->hari_tgl_7 ?? '' }}</p>

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
                        if(isset($tugasPeleton->created_at)) {
                        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember'];

                        $date = new DateTime($tugasPeleton->created_at);
                        $dayName = strtoupper($days[$date->format('w')]);
                        $day = $date->format('d');
                        $monthName = strtoupper($months[$date->format('n')]);
                        $year = $date->format('Y');

                        echo $dayName . ', ' . $day . ' ' . $monthName . ' ' . $year;
                        } else {
                        echo '-';
                        }
                        @endphp
                    </td>
                </tr>
            </table>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="no-col" rowspan="2">NO</th>
                    <th class="nama-col" rowspan="2">NAMA</th>
                    <th class="nama-col" rowspan="2">NOSIS</th>
                    <th colspan="7">HARI</th>
                    <th class="keterangan-col" rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th class="hari-col header-col">HARI
                        1<br>{{ $tugasPeleton->hari_tgl_1 ?? '' }}</th>
                    <th class="hari-col header-col">HARI
                        2<br>{{ $tugasPeleton->hari_tgl_2 ?? '' }}</th>
                    <th class="hari-col header-col">HARI
                        3<br>{{ $tugasPeleton->hari_tgl_3 ?? '' }}</th>
                    <th class="hari-col header-col">HARI
                        4<br>{{ $tugasPeleton->hari_tgl_4 ?? '' }}</th>
                    <th class="hari-col header-col">HARI
                        5<br>{{ $tugasPeleton->hari_tgl_5 ?? '' }}</th>
                    <th class="hari-col header-col">HARI
                        6<br>{{ $tugasPeleton->hari_tgl_6 ?? '' }}</th>
                    <th class="hari-col header-col">HARI
                        7<br>{{ $tugasPeleton->hari_tgl_7 ?? '' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tugasSiswa as $index => $siswa)
                @if($siswa->penilaianHarian)
                @php
                $nilaiArray = [
                $siswa->penilaianHarian->nilai_harian_1,
                $siswa->penilaianHarian->nilai_harian_2,
                $siswa->penilaianHarian->nilai_harian_3,
                $siswa->penilaianHarian->nilai_harian_4,
                $siswa->penilaianHarian->nilai_harian_5,
                $siswa->penilaianHarian->nilai_harian_6,
                $siswa->penilaianHarian->nilai_harian_7
                ];
                $rataRata = array_sum($nilaiArray) / count(array_filter($nilaiArray, function($value) {
                return $value !== null;
                }));
                @endphp
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td class="text-left nama-col nowrap">{{ $siswa->siswa->nama }}</td>
                    <td class="text-left nama-col nowrap">{{ $siswa->siswa->nosis }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_1 }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_2 }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_3 }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_4 }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_5 }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_6 }}</td>
                    <td class="hari-col">{{ $siswa->penilaianHarian->nilai_harian_7 }}</td>
                    <td class="text-left keterangan-col">{{ $siswa->penilaianHarian->keterangan }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <!-- Footer Section -->
        <div class="footer-section">
            <div class="date-location">
                PADANG,
                @php
                if(isset($tugasPeleton->created_at)) {
                $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'];

                $date = new DateTime($tugasPeleton->created_at);
                $dayName = strtoupper($days[$date->format('w')]);
                $day = $date->format('d');
                $monthName = strtoupper($months[$date->format('n')]);
                $year = $date->format('Y');

                echo $dayName . ', ' . $day . ' ' . $monthName . ' ' . $year;
                } else {
                echo '-';
                }
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
</body>

</html>