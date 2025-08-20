<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\TugasPeleton;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private $bulanNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    public function index(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'bulan' => 'sometimes|integer|between:1,12',
            'tahun' => 'sometimes|integer|digits:4'
        ]);

        // Konversi bulan ke integer
        $bulan = (int)($validated['bulan'] ?? date('m'));
        $tahun = (int)($validated['tahun'] ?? date('Y'));

        // Format nama bulan
        $namaBulan = $this->bulanNames[$bulan] ?? 'Bulan Tidak Valid';
        $namaBulan .= ' ' . $tahun;

        // Ambil semua siswa (diurutkan berdasarkan nama)
        $siswas = Siswa::orderBy('nama')->get();

        // Ambil semua tugas peleton dalam bulan tersebut
        $tugasPeletons = TugasPeleton::with([
                'tugasSiswa.siswa', 
                'tugasSiswa.penilaianMingguan',
                'peleton' // relasi ke user (peleton)
            ])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->orderBy('minggu_ke', 'asc')
            ->get();

        // Kelompokkan berdasarkan minggu_ke
        $mingguGroups = $tugasPeletons->groupBy('minggu_ke');

        // Siapkan data laporan untuk semua siswa
        $laporan = [];

        foreach ($siswas as $siswa) {
            $nilaiMingguan = [];
            $totalNilai = 0;
            $peletonInfo = [];

            foreach ($mingguGroups as $mingguKe => $tugasPeletonGroup) {
                foreach ($tugasPeletonGroup as $tugasPeleton) {
                    $tugasSiswa = $tugasPeleton->tugasSiswa->where('siswa_id', $siswa->id)->first();

                    if ($tugasSiswa && $tugasSiswa->penilaianMingguan) {
                        $nilai = (float)($tugasSiswa->penilaianMingguan->nilai_mingguan ?? 0);
                        $nilaiMingguan[$mingguKe] = $nilai;
                        $totalNilai += $nilai;

                        // Simpan info peleton yang menilai
                        if ($tugasPeleton->peleton) {
                            $peletonInfo[$mingguKe] = $tugasPeleton->peleton->name;
                        }
                    }
                }
            }

            // Tambahkan semua siswa ke laporan
            $laporan[] = [
                'siswa' => $siswa,
                'total_nilai' => $totalNilai,
                'nilai_mingguan' => $nilaiMingguan,
                'peleton' => $peletonInfo,
                'memiliki_nilai' => $totalNilai > 0
            ];
        }

        // Urutkan berdasarkan total nilai (yang memiliki nilai di atas)
        $this->prosesRanking($laporan);

        // Siapkan data untuk grafik rank
        $chartData = $this->prepareChartData($laporan);

        return view('superadmin.laporan.index', [
            'laporan' => $laporan,
            'mingguGroups' => $mingguGroups,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan,
            'bulanNames' => $this->bulanNames,
            'chartData' => $chartData
        ]);
    }

    private function prosesRanking(&$laporan)
    {
        // Urutkan descending
        usort($laporan, function($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        // Hitung rank persis seperti Excel
        $values = array_column($laporan, 'total_nilai');
        foreach ($laporan as $i => &$item) {
            if (!$item['memiliki_nilai']) {
                $item['rank'] = null;
                continue;
            }
            
            $currentValue = $item['total_nilai'];
            $rank = 1;
            $count = 0;
            
            // Hitung RANK (nilai lebih besar)
            foreach ($values as $value) {
                if ($value > $currentValue) $rank++;
            }
            
            // Hitung COUNTIF (nilai sama sebelumnya)
            for ($j = 0; $j < $i; $j++) {
                if ($values[$j] === $currentValue) $count++;
            }
            
            $item['rank'] = $rank + $count;
        }
    }

    private function prepareChartData($laporan)
    {
        // Cek jika laporan kosong
        if (empty($laporan)) {
            return ['rankData' => []];
        }
    
        $rankData = array_map(function($item) {
            return [
                'name' => $item['siswa']->nama,
                'rank' => $item['rank'] ?? null,
                'total_nilai' => $item['total_nilai'] ?? 0,
                'has_rank' => isset($item['rank'])
            ];
        }, $laporan);
    
        usort($rankData, function($a, $b) {
            if ($a['rank'] === null && $b['rank'] === null) {
                return strcmp($a['name'], $b['name']);
            }
            if ($a['rank'] === null) return 1;
            if ($b['rank'] === null) return -1;
            return $a['rank'] <=> $b['rank'];
        });
    
        return ['rankData' => $rankData];
    }
}