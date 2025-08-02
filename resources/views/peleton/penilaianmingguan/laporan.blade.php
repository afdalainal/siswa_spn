<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Mingguan</title>
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

    .signature {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .signature-box {
        text-align: center;
        width: 200px;
    }

    .page-break {
        page-break-after: always;
    }

    .keterangan {
        margin-top: 10px;
        border: 1px solid #000;
        padding: 5px;
        font-size: 10px;
    }

    .highlight {
        background-color: #ffff99;
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
            <h2>LEMBAR PENILAIAN MINGGUAN</h2>
            <p>SEKOLAH KECABANGAN {{ strtoupper($tugasPeleton->ton_ki_yon ?? '') }}</p>
            <p>MINGGU KE {{ $tugasPeleton->minggu_ke ?? '' }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NAMA/NOSIS</th>
                    <th colspan="7">NILAI HARIAN</th>
                    <th rowspan="2">NILAI MINGGUAN</th>
                    <th rowspan="2">RANK MINGGUAN</th>
                    <th rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th>HARI 1<br>{{ $tugasPeleton->hari_tgl_1 ?? '' }}<br>{{ $tugasPeleton->tempat_1 ?? '' }}</th>
                    <th>HARI 2<br>{{ $tugasPeleton->hari_tgl_2 ?? '' }}<br>{{ $tugasPeleton->tempat_2 ?? '' }}</th>
                    <th>HARI 3<br>{{ $tugasPeleton->hari_tgl_3 ?? '' }}<br>{{ $tugasPeleton->tempat_3 ?? '' }}</th>
                    <th>HARI 4<br>{{ $tugasPeleton->hari_tgl_4 ?? '' }}<br>{{ $tugasPeleton->tempat_4 ?? '' }}</th>
                    <th>HARI 5<br>{{ $tugasPeleton->hari_tgl_5 ?? '' }}<br>{{ $tugasPeleton->tempat_5 ?? '' }}</th>
                    <th>HARI 6<br>{{ $tugasPeleton->hari_tgl_6 ?? '' }}<br>{{ $tugasPeleton->tempat_6 ?? '' }}</th>
                    <th>HARI 7<br>{{ $tugasPeleton->hari_tgl_7 ?? '' }}<br>{{ $tugasPeleton->tempat_7 ?? '' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tugasSiswa as $index => $siswa)
                @if($siswa->penilaianMingguan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $siswa->siswa->nama }}<br>{{ $siswa->siswa->nosis }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_1 }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_2 }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_3 }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_4 }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_5 }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_6 }}</td>
                    <td>{{ $siswa->penilaianMingguan->nilai_mingguan_hari_7 }}</td>
                    <td class="highlight">{{ $siswa->penilaianMingguan->nilai_mingguan }}</td>
                    <td class="highlight">{{ $siswa->penilaianMingguan->rank_mingguan }}</td>
                    <td class="text-left">{{ $siswa->penilaianMingguan->keterangan }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <div class="signature-box">
                <p>DAN TON {{ $tugasPeleton->ton_ki_yon ?? '' }}</p>
                <br><br><br>
                <p>(_______________________)</p>
                <p>Nrp. {{ $tugasPeleton->pengasuhDanton->pangkat_nrp ?? '' }}</p>
            </div>
            <div class="signature-box">
                <p>DAN KI {{ $tugasPeleton->ton_ki_yon ?? '' }}</p>
                <br><br><br>
                <p>(_______________________)</p>
                <p>Nrp. {{ $tugasPeleton->pengasuhDanki->pangkat_nrp ?? '' }}</p>
            </div>
            <div class="signature-box">
                <p>DANMEN {{ $tugasPeleton->ton_ki_yon ?? '' }}</p>
                <br><br><br>
                <p>(_______________________)</p>
                <p>Nrp. {{ $tugasPeleton->pengasuhDanmen->pangkat_nrp ?? '' }}</p>
            </div>
        </div>
    </div>


</body>

</html>