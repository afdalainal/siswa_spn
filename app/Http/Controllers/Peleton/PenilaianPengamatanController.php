<?php

namespace App\Http\Controllers\Peleton;

use App\Http\Controllers\Controller;
use App\Models\TugasPeleton;
use App\Models\Pengasuh;
use App\Models\User;
use App\Models\Siswa;
use App\Models\TugasSiswa;
use App\Models\PenilaianPengamatan;
use App\Models\PenilaianHarian;
use App\Models\PenilaianMingguan;
use App\Models\PenilaianSiswaHarian;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianPengamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugaspeleton = TugasPeleton::withTrashed()
            ->with(['pengasuhDanton', 'pengasuhDanki', 'pengasuhDanmen', 'peleton'])
            ->where('user_id', auth()->id())
            ->get();
    
        return view('peleton.penilaianpengamatan.index', compact('tugaspeleton'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tugasPeleton = TugasPeleton::with([
                'tugasSiswa' => function($query) {
                    $query->with([
                        'siswa:id,nama,nosis',
                        'penilaianSiswaHarian' => function($q) {
                            $q->with('penilaianPengamatan');
                        }
                    ]);
                },
                'pengasuhDanton:id,nama',
                'pengasuhDanki:id,nama',
                'peleton:id,name'
            ])
            ->withTrashed()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        return view('peleton.penilaianpengamatan.listpenilaian', [
            'tugasPeleton' => $tugasPeleton,
            'tugasSiswa' => $tugasPeleton->tugasSiswa
        ]);
    }
    
    public function showHarian($tugasPeletonId, $tugasSiswaId)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->where('id', $tugasPeletonId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $tugasSiswa = TugasSiswa::with([
                'siswa:id,nama,nosis',
                'penilaianSiswaHarian.penilaianPengamatan'
            ])
            ->where('id', $tugasSiswaId)
            ->where('tugas_peleton_id', $tugasPeletonId)
            ->firstOrFail();

        return view('peleton.penilaianpengamatan.listhari', [
            'tugasPeleton' => $tugasPeleton,
            'tugasSiswa' => $tugasSiswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penilaianpengamatan = PenilaianPengamatan::with([
                'penilaianSiswaHarian.tugasSiswa.siswa',
                'penilaianSiswaHarian.tugasSiswa.tugasPeleton'
            ])
            ->findOrFail($id);

        if (
            !$penilaianpengamatan->penilaianSiswaHarian ||
            !$penilaianpengamatan->penilaianSiswaHarian->tugasSiswa ||
            !$penilaianpengamatan->penilaianSiswaHarian->tugasSiswa->tugasPeleton ||
            $penilaianpengamatan->penilaianSiswaHarian->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

        return view('peleton.penilaianpengamatan.show', [
            'penilaianpengamatan' => $penilaianpengamatan,
            'tugasPeleton' => $penilaianpengamatan->penilaianSiswaHarian->tugasSiswa->tugasPeleton,
            'siswa' => $penilaianpengamatan->penilaianSiswaHarian->tugasSiswa->siswa,
            'penilaianHarian' => $penilaianpengamatan->penilaianSiswaHarian
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mental_spiritual_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_spiritual_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_spiritual_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_ideologi_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_ideologi_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_ideologi_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kejuangan_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kejuangan_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kejuangan_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kejuangan_4' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'watak_pribadi_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'watak_pribadi_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'watak_pribadi_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'watak_pribadi_4' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_4' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_5' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_6' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_7' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'mental_kepemimpinan_8' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'jumlah_indikator' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'skor' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_konversi' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'pelanggaran_prestasi_minus' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'pelanggaran_prestasi_plus' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_akhir' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'rank_harian' => 'nullable|numeric|between:-99999999.99,99999999.99',
        ]);
    
        $penilaian = PenilaianPengamatan::with(['penilaianSiswaHarian.tugasSiswa.tugasPeleton'])
            ->findOrFail($id);
    
        if (
            !$penilaian->penilaianSiswaHarian ||
            !$penilaian->penilaianSiswaHarian->tugasSiswa ||
            !$penilaian->penilaianSiswaHarian->tugasSiswa->tugasPeleton ||
            $penilaian->penilaianSiswaHarian->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data ini.');
        }
    
        // Update data penilaian pengamatan
        $penilaian->update($request->only([
            'mental_spiritual_1',
            'mental_spiritual_2',
            'mental_spiritual_3',
            'mental_ideologi_1',
            'mental_ideologi_2',
            'mental_ideologi_3',
            'mental_kejuangan_1',
            'mental_kejuangan_2',
            'mental_kejuangan_3',
            'mental_kejuangan_4',
            'watak_pribadi_1',
            'watak_pribadi_2',
            'watak_pribadi_3',
            'watak_pribadi_4',
            'mental_kepemimpinan_1',
            'mental_kepemimpinan_2',
            'mental_kepemimpinan_3',
            'mental_kepemimpinan_4',
            'mental_kepemimpinan_5',
            'mental_kepemimpinan_6',
            'mental_kepemimpinan_7',
            'mental_kepemimpinan_8',
            'jumlah_indikator',
            'skor',
            'nilai_konversi',
            'pelanggaran_prestasi_minus',
            'pelanggaran_prestasi_plus',
            'nilai_akhir',
            'rank_harian',
        ]));
    
        // **FUNGSI BARU: Auto save nilai_akhir ke penilaian_harians dan penilaian_mingguans**
        $this->updatePenilaianHarianAndMingguan($penilaian, $request->nilai_akhir);
    
        return redirect()->route('penilaianpengamatan.index')->with([
            'message' => 'Data penilaian berhasil disimpan!',
            'alert-type' => 'success'
        ]);
    }
    
    /**
     * Update nilai_akhir ke tabel penilaian_harians dan penilaian_mingguans
     * berdasarkan hari_ke dari penilaian_siswa_harian
     */
    private function updatePenilaianHarianAndMingguan($penilaian, $nilaiAkhir)
    {
        // Ambil data yang diperlukan
        $penilaianSiswaHarian = $penilaian->penilaianSiswaHarian;
        $tugasSiswaId = $penilaianSiswaHarian->tugas_siswa_id;
        $hariKe = $penilaianSiswaHarian->hari_ke;
    
        // Tentukan field yang akan diupdate berdasarkan hari_ke
        $fieldHarian = 'nilai_harian_' . $hariKe;
        $fieldMingguan = 'nilai_mingguan_hari_' . $hariKe;
    
        // Update atau create data di tabel penilaian_harians
        PenilaianHarian::updateOrCreate(
            ['tugas_siswa_id' => $tugasSiswaId],
            [$fieldHarian => $nilaiAkhir]
        );
    
        // Update atau create data di tabel penilaian_mingguans
        $penilaianMingguan = PenilaianMingguan::updateOrCreate(
            ['tugas_siswa_id' => $tugasSiswaId],
            [$fieldMingguan => $nilaiAkhir]
        );

        // **FUNGSI BARU: Hitung ulang nilai_mingguan secara otomatis**
        $this->recalculateNilaiMingguan($penilaianMingguan);
    }

    /**
     * Hitung ulang nilai_mingguan berdasarkan rata-rata nilai harian yang ada
     * Rumus: SUM(nilai_mingguan_hari_1 sampai nilai_mingguan_hari_7) / jumlah_nilai_yang_ada
     */
    private function recalculateNilaiMingguan($penilaianMingguan)
    {
        // Array field nilai harian
        $nilaiHarianFields = [
            'nilai_mingguan_hari_1',
            'nilai_mingguan_hari_2',
            'nilai_mingguan_hari_3',
            'nilai_mingguan_hari_4',
            'nilai_mingguan_hari_5',
            'nilai_mingguan_hari_6',
            'nilai_mingguan_hari_7'
        ];

        $totalNilai = 0;
        $jumlahNilaiAda = 0;

        foreach ($nilaiHarianFields as $field) {
            $nilai = $penilaianMingguan->$field;
            
            // Hanya hitung jika nilai tidak null dan tidak kosong
            if (!is_null($nilai) && $nilai !== '') {
                $totalNilai += (float) $nilai;
                $jumlahNilaiAda++;
            }
        }

        // Jika ada nilai yang dihitung, update nilai_mingguan dengan rata-rata
        // Jika tidak ada nilai sama sekali, set nilai_mingguan menjadi null
        if ($jumlahNilaiAda > 0) {
            $nilaiMingguan = round($totalNilai / $jumlahNilaiAda, 2);
        } else {
            $nilaiMingguan = null;
        }

        // Update nilai_mingguan
        $penilaianMingguan->update(['nilai_mingguan' => $nilaiMingguan]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function grafik(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with([
                'tugasSiswa.siswa',
                'tugasSiswa.penilaianSiswaHarian.penilaianPengamatan' 
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $grafikData = [];
        
        foreach ($tugasPeleton->tugasSiswa as $tugasSiswa) {
            foreach ($tugasSiswa->penilaianSiswaHarian as $harian) {
                if ($harian->penilaianPengamatan) {
                    $grafikData[] = [
                        'nama_siswa' => $tugasSiswa->siswa->nama,
                        'nilai_akhir' => $harian->penilaianPengamatan->nilai_akhir,
                        'nilai_konversi' => $harian->penilaianPengamatan->nilai_konversi,
                        'skor' => $harian->penilaianPengamatan->skor,
                        'rank_harian' => $harian->penilaianPengamatan->rank_harian
                    ];
                }
            }
        }
    
        return view('peleton.penilaianpengamatan.grafik', compact('tugasPeleton', 'grafikData'));
    }

    public function laporan(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with([
                'tugasSiswa.siswa',
                'tugasSiswa.penilaianSiswaHarian.penilaianPengamatan',
                'pengasuhDanton',
                'pengasuhDanki',
                'pengasuhDanmen'
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $dataHarian = [];
        
        // Loop untuk setiap hari (1-7)
        for ($hari = 1; $hari <= 7; $hari++) {
            $siswaHarian = [];
            
            // Kumpulkan data siswa untuk hari ini
            foreach ($tugasPeleton->tugasSiswa as $tugasSiswa) {
                $penilaianHarian = $tugasSiswa->penilaianSiswaHarian()
                    ->where('hari_ke', $hari)
                    ->with('penilaianPengamatan')
                    ->first();
                    
                if ($penilaianHarian && $penilaianHarian->penilaianPengamatan) {
                    $siswaHarian[] = [
                        'siswa' => $tugasSiswa->siswa,
                        'penilaianPengamatan' => $penilaianHarian->penilaianPengamatan,
                        'penilaian_id' => $penilaianHarian->penilaianPengamatan->id
                    ];
                }
            }
            
            // **FUNGSI BARU: Hitung dan update rank_harian untuk hari ini**
            if (!empty($siswaHarian)) {
                $this->calculateAndUpdateRankHarian($siswaHarian, $hari);
                
                // Refresh data setelah update ranking
                foreach ($siswaHarian as &$siswaData) {
                    $siswaData['penilaianPengamatan']->refresh();
                }
                
                // **URUTKAN DATA BERDASARKAN RANK_HARIAN (ASC)**
                usort($siswaHarian, function($a, $b) {
                    $rankA = $a['penilaianPengamatan']->rank_harian ?? 999999;
                    $rankB = $b['penilaianPengamatan']->rank_harian ?? 999999;
                    return $rankA <=> $rankB; // Ascending order (1, 2, 3, ...)
                });
            }
            
            $dataHarian[$hari] = $siswaHarian;
        }
    
        if (request()->has('download')) {
            $pdf = Pdf::loadView('peleton.penilaianpengamatan.laporan', compact('dataHarian', 'tugasPeleton'))
                      ->setPaper('a4', 'landscape');
            
            return $pdf->stream('laporan-penilaian-pengamatan.pdf');
        }
    
        return view('peleton.penilaianpengamatan.laporan', compact('dataHarian', 'tugasPeleton'));
    }
    
    /**
     * Hitung dan update rank_harian berdasarkan nilai_akhir
     * Menggunakan rumus Excel: =RANK(nilai,$range)+COUNTIF($range,nilai)-1
     * 
     * @param array $siswaHarian Array data siswa untuk hari tertentu
     * @param int $hari Hari ke berapa (1-7)
     */
    private function calculateAndUpdateRankHarian($siswaHarian, $hari)
    {
        // Ambil semua nilai_akhir dan urutkan dari tertinggi ke terendah
        $nilaiAkhirData = [];
        foreach ($siswaHarian as $siswaData) {
            $nilaiAkhir = $siswaData['penilaianPengamatan']->nilai_akhir;
            if (!is_null($nilaiAkhir)) {
                $nilaiAkhirData[] = [
                    'penilaian_id' => $siswaData['penilaian_id'],
                    'nilai_akhir' => (float) $nilaiAkhir
                ];
            }
        }
        
        // Jika tidak ada data nilai, skip
        if (empty($nilaiAkhirData)) {
            return;
        }
        
        // Urutkan berdasarkan nilai_akhir dari tertinggi ke terendah
        usort($nilaiAkhirData, function($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir']; // Descending order
        });
        
        // Buat array untuk menyimpan semua nilai (untuk COUNTIF)
        $allNilai = array_column($nilaiAkhirData, 'nilai_akhir');
        
        // Hitung rank untuk setiap siswa
        $rankUpdates = [];
        
        foreach ($nilaiAkhirData as $index => $data) {
            $nilaiAkhir = $data['nilai_akhir'];
            $penilaianId = $data['penilaian_id'];
            
            // Implementasi rumus Excel: =RANK(nilai,$range)+COUNTIF($range,nilai)-1
            
            // 1. RANK(nilai, $range) - hitung berapa banyak nilai yang lebih tinggi + 1
            $rank = 1;
            foreach ($allNilai as $nilai) {
                if ($nilai > $nilaiAkhir) {
                    $rank++;
                }
            }
            
            // 2. COUNTIF($range, nilai) - hitung berapa banyak nilai yang sama
            $countSame = 0;
            foreach ($allNilai as $nilai) {
                if ($nilai == $nilaiAkhir) {
                    $countSame++;
                }
            }
            
            // 3. Aplikasikan rumus: RANK + COUNTIF - 1
            // Tapi kita perlu menyesuaikan untuk urutan kemunculan
            $countBefore = 0;
            foreach ($nilaiAkhirData as $beforeIndex => $beforeData) {
                if ($beforeIndex >= $index) break;
                if ($beforeData['nilai_akhir'] == $nilaiAkhir) {
                    $countBefore++;
                }
            }
            
            $finalRank = $rank + $countBefore;
            
            $rankUpdates[] = [
                'penilaian_id' => $penilaianId,
                'rank_harian' => $finalRank
            ];
        }
        
        // Update rank_harian di database
        foreach ($rankUpdates as $update) {
            try {
                PenilaianPengamatan::where('id', $update['penilaian_id'])
                    ->update(['rank_harian' => $update['rank_harian']]);
                    
                Log::info("Updated rank_harian for penilaian_id {$update['penilaian_id']} to {$update['rank_harian']} (Hari: {$hari})");
            } catch (\Exception $e) {
                Log::error("Failed to update rank_harian for penilaian_id {$update['penilaian_id']}: " . $e->getMessage());
            }
        }
    }

}