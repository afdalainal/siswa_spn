<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan Penilaian Siswa</title>
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
        position: relative;
        margin-bottom: 5px;
    }

    .header-left {
        position: absolute;
        top: 0;
        left: 0;
        border: 1px solid #000;
        padding: 8px;
        background-color: #fff;
        z-index: 10;
        min-width: 200px;
    }

    .header-left p {
        margin: 2px 0;
        font-size: 9px;
        font-weight: bold;
        text-align: center;
        line-height: 1.2;
    }

    .header-center {
        text-align: center;
        padding-top: 10px;
    }

    .header-center h2 {
        margin: 2px 0;
        font-size: 12px;
    }

    .header-center p {
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
        margin-top: 35px;
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

    .text-muted {
        color: #666;
    }

    .nowrap {
        white-space: nowrap;
    }

    /* Column width adjustments */
    .no-col {
        width: 4%;
    }

    .nama-col {
        width: 15%;
        min-width: 100px;
    }

    .nosis-col {
        width: 10%;
        min-width: 70px;
    }

    .minggu-col {
        width: 8%;
    }

    .total-col {
        width: 8%;
    }

    .rank-col {
        width: 6%;
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

    .small-text {
        font-size: 6px;
        color: #666;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 1024px) {
        .header-left {
            position: relative;
            margin-bottom: 15px;
            width: auto;
            display: inline-block;
        }

        .header-center {
            padding-top: 0;
        }

        .data-table {
            font-size: 6px;
        }

        .header-left p {
            font-size: 8px;
        }
    }

    @media screen and (max-width: 768px) {
        body {
            padding: 3mm;
        }

        .header-left {
            min-width: 150px;
            padding: 6px;
        }

        .header-left p {
            font-size: 7px;
        }

        .data-table {
            font-size: 5px;
        }

        .header-center h2 {
            font-size: 10px;
        }

        .header-center p {
            font-size: 8px;
        }
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

        .header-center h2 {
            font-size: 11px;
        }

        .header-center p {
            font-size: 8px;
        }

        .signature-table {
            font-size: 7px;
        }

        .date-location {
            font-size: 7px;
        }

        .header-left {
            position: absolute;
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

            <div class="header-left">
                <p class="header-title">KEPOLISIAN NEGARA REPUBLIK INDONESIA</p>
                <p class="header-title">DAERAH SUMATERA BARAT</p>
                <p class="header-title">SEKOLAH POLISI NEGARA</p>
            </div>

            <div class="header-center">
                <p class="header-subtitle">REKAPITULASI HASIL PENILAIAN SISWA (BULANAN)</p>
                <p>SISWA DIKTUK BINTARA POLRI GEL II TAHUN 2025</p>
            </div>

            <table class="header-info">
                <tr>
                    <td class="header-info-left">
                        PERIODE : {{ strtoupper($namaBulan) }}
                    </td>
                    <td class="header-info-right">
                        @if(count($mingguGroups) > 0)
                        MINGGU {{ implode(', ', array_keys($mingguGroups->toArray())) }}
                        @else
                        -
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if(count($mingguGroups) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th class="no-col">NO</th>
                    <th class="nama-col">NAMA SISWA</th>
                    <th class="nosis-col">NOSIS</th>
                    @foreach($mingguGroups as $mingguKe => $group)
                    <th class="minggu-col header-col">MINGGU {{ $mingguKe }}</th>
                    @endforeach
                    <th class="total-col">TOTAL NILAI</th>
                    <th class="rank-col">RANK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $item)
                <tr class="{{ $item['memiliki_nilai'] ? '' : 'text-muted' }}">
                    <td class="no-col">{{ $loop->iteration }}</td>
                    <td class="text-left nama-col nowrap">{{ $item['siswa']->nama }}</td>
                    <td class="text-left nosis-col nowrap">{{ $item['siswa']->nosis }}</td>
                    @foreach($mingguGroups as $mingguKe => $group)
                    <td class="minggu-col">
                        @if(isset($item['nilai_mingguan'][$mingguKe]))
                        {{ number_format($item['nilai_mingguan'][$mingguKe]) }}
                        @if(isset($item['peleton'][$mingguKe]))
                        <br><span class="small-text">({{ $item['peleton'][$mingguKe] }})</span>
                        @endif
                        @else
                        -
                        @endif
                    </td>
                    @endforeach
                    <td class="total-col">
                        @if($item['memiliki_nilai'])
                        <strong>{{ number_format($item['total_nilai']) }}</strong>
                        @else
                        -
                        @endif
                    </td>
                    <td class="rank-col">
                        @if($item['memiliki_nilai'])
                        {{ $item['rank'] }}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; margin-top: 20px; font-size: 10px;">
            <strong>Tidak ada data laporan untuk ditampilkan pada bulan ini</strong>
        </div>
        @endif

        <!-- Footer Section -->
        <div class="footer-section">
            <div class="date-location">
                PADANG,
                {{ isset($tanggalCetak) && !empty($tanggalCetak) ? strtoupper($tanggalCetak) : strtoupper(date('j') . ' ' . ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][date('n')] . ' ' . date('Y')) }}
            </div>
        </div>
    </div>
</body>

</html>