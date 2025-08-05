<?php

namespace App\Http\Controllers\Peleton;

use App\Http\Controllers\Controller;
use App\Models\TugasPeleton;
use App\Models\Pengasuh;
use App\Models\User;
use App\Models\Siswa;
use App\Models\TugasSiswa;
use App\Models\PenilaianHarian;
use App\Models\PenilaianPengamatan;
use App\Models\PenilaianMingguan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;


class PenilaianMingguanController extends Controller
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
    
        return view('peleton.penilaianmingguan.index', compact('tugaspeleton'));
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
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with(['tugasSiswa.siswa', 'tugasSiswa.penilaianmingguan'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $tugasSiswa = $tugasPeleton->tugasSiswa;
    
        return view('peleton.penilaianmingguan.listpenilaian', compact('tugasSiswa', 'tugasPeleton'));
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penilaianmingguan = PenilaianMingguan::with('tugasSiswa.tugasPeleton', 'tugasSiswa.siswa')
            ->findOrFail($id);
    
        if (
            !$penilaianmingguan->tugasSiswa ||
            !$penilaianmingguan->tugasSiswa->tugasPeleton ||
            $penilaianmingguan->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }
    
        return view('peleton.penilaianmingguan.show', compact('penilaianmingguan'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nilai_mingguan_hari_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan_hari_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan_hari_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan_hari_4' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan_hari_5' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan_hari_6' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan_hari_7' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_mingguan' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'rank_mingguan' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'keterangan' => 'nullable|string',
        ]);

        $penilaian = PenilaianMingguan::with(['tugasSiswa.tugasPeleton', 'tugasSiswa.siswa'])
            ->findOrFail($id);
    
        if (
            !$penilaian->tugasSiswa ||
            !$penilaian->tugasSiswa->tugasPeleton ||
            $penilaian->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data ini.');
        }
    
        $penilaian->update($request->only([
            'nilai_mingguan_hari_1',
            'nilai_mingguan_hari_2',
            'nilai_mingguan_hari_3',
            'nilai_mingguan_hari_4',
            'nilai_mingguan_hari_5',
            'nilai_mingguan_hari_6',
            'nilai_mingguan_hari_7',
            'nilai_mingguan',
            'rank_mingguan',
            'keterangan',
        ]));
    
        return redirect()->route('penilaianmingguan.index')->with([
            'message' => 'Data penilaian berhasil disimpan!',
            'alert-type' => 'success'
        ]);
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
            ->with(['tugasSiswa.siswa', 'tugasSiswa.penilaianMingguan'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $tugasSiswa = $tugasPeleton->tugasSiswa;

        $grafikData = [];
        foreach ($tugasSiswa as $siswa) {
            if ($siswa->penilaianMingguan) {
                $grafikData[] = [
                    'nama_siswa' => $siswa->siswa->nama,
                    'nilai_hari_1' => $siswa->penilaianMingguan->nilai_mingguan_hari_1,
                    'nilai_hari_2' => $siswa->penilaianMingguan->nilai_mingguan_hari_2,
                    'nilai_hari_3' => $siswa->penilaianMingguan->nilai_mingguan_hari_3,
                    'nilai_hari_4' => $siswa->penilaianMingguan->nilai_mingguan_hari_4,
                    'nilai_hari_5' => $siswa->penilaianMingguan->nilai_mingguan_hari_5,
                    'nilai_hari_6' => $siswa->penilaianMingguan->nilai_mingguan_hari_6,
                    'nilai_hari_7' => $siswa->penilaianMingguan->nilai_mingguan_hari_7,
                    'nilai_mingguan' => $siswa->penilaianMingguan->nilai_mingguan,
                    'rank_mingguan' => $siswa->penilaianMingguan->rank_mingguan
                ];
            }
        }

        return view('peleton.penilaianmingguan.grafik', compact('tugasPeleton', 'grafikData'));
    }

    public function laporan(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with([
                'tugasSiswa.siswa', 
                'tugasSiswa.penilaianMingguan',
                'pengasuhDanton',
                'pengasuhDanki',
                'pengasuhDanmen'
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $tugasSiswa = $tugasPeleton->tugasSiswa;
    
        // **FUNGSI BARU: Hitung dan update rank_mingguan berdasarkan nilai_mingguan**
        $this->calculateAndUpdateRankMingguan($tugasSiswa);
    
        // **URUTKAN DATA BERDASARKAN RANK_MINGGUAN (ASC)**
        $tugasSiswa = $tugasSiswa->sortBy(function($siswa) {
            return $siswa->penilaianMingguan->rank_mingguan ?? 999999;
        })->values(); // Reset array keys
    
        if (request()->has('download')) {
            $pdf = Pdf::loadView('peleton.penilaianmingguan.laporan', compact('tugasSiswa', 'tugasPeleton'))
                      ->setPaper('a4', 'landscape');
            
            return $pdf->stream('laporan-penilaian-mingguan.pdf');
        }
    
        return view('peleton.penilaianmingguan.laporan', compact('tugasSiswa', 'tugasPeleton'));
    }
    
    /**
     * Hitung dan update rank_mingguan berdasarkan nilai_mingguan
     * Menggunakan rumus Excel: =RANK(nilai,$range)+COUNTIF($range,nilai)-1
     * 
     * @param \Illuminate\Database\Eloquent\Collection $tugasSiswa
     */
    private function calculateAndUpdateRankMingguan($tugasSiswa)
    {
        // Kumpulkan data nilai_mingguan dari semua siswa yang memiliki penilaian mingguan
        $nilaiMingguanData = [];
        
        foreach ($tugasSiswa as $siswa) {
            if ($siswa->penilaianMingguan && !is_null($siswa->penilaianMingguan->nilai_mingguan)) {
                $nilaiMingguanData[] = [
                    'penilaian_id' => $siswa->penilaianMingguan->id,
                    'nilai_mingguan' => (float) $siswa->penilaianMingguan->nilai_mingguan
                ];
            }
        }
        
        // Jika tidak ada data nilai, skip
        if (empty($nilaiMingguanData)) {
            Log::info("No nilai_mingguan data found for ranking calculation");
            return;
        }
        
        // Urutkan berdasarkan nilai_mingguan dari tertinggi ke terendah untuk ranking
        usort($nilaiMingguanData, function($a, $b) {
            return $b['nilai_mingguan'] <=> $a['nilai_mingguan']; // Descending order
        });
        
        // Buat array untuk menyimpan semua nilai (untuk COUNTIF)
        $allNilai = array_column($nilaiMingguanData, 'nilai_mingguan');
        
        // Hitung rank untuk setiap siswa
        $rankUpdates = [];
        
        foreach ($nilaiMingguanData as $index => $data) {
            $nilaiMingguan = $data['nilai_mingguan'];
            $penilaianId = $data['penilaian_id'];
            
            // Implementasi rumus Excel: =RANK(nilai,$range)+COUNTIF($range,nilai)-1
            
            // 1. RANK(nilai, $range) - hitung berapa banyak nilai yang lebih tinggi + 1
            $rank = 1;
            foreach ($allNilai as $nilai) {
                if ($nilai > $nilaiMingguan) {
                    $rank++;
                }
            }
            
            // 2. COUNTIF untuk nilai yang sama - hitung urutan kemunculan
            $countBefore = 0;
            foreach ($nilaiMingguanData as $beforeIndex => $beforeData) {
                if ($beforeIndex >= $index) break;
                if ($beforeData['nilai_mingguan'] == $nilaiMingguan) {
                    $countBefore++;
                }
            }
            
            // 3. Aplikasikan rumus: RANK + COUNTIF_BEFORE
            $finalRank = $rank + $countBefore;
            
            $rankUpdates[] = [
                'penilaian_id' => $penilaianId,
                'rank_mingguan' => $finalRank,
                'nilai_mingguan' => $nilaiMingguan
            ];
        }
        
        // Update rank_mingguan di database
        foreach ($rankUpdates as $update) {
            try {
                PenilaianMingguan::where('id', $update['penilaian_id'])
                    ->update(['rank_mingguan' => $update['rank_mingguan']]);
                    
                Log::info("Updated rank_mingguan for penilaian_id {$update['penilaian_id']} to {$update['rank_mingguan']} (Nilai: {$update['nilai_mingguan']})");
            } catch (\Exception $e) {
                Log::error("Failed to update rank_mingguan for penilaian_id {$update['penilaian_id']}: " . $e->getMessage());
            }
        }
        
        // Refresh data setelah update
        foreach ($tugasSiswa as $siswa) {
            if ($siswa->penilaianMingguan) {
                $siswa->penilaianMingguan->refresh();
            }
        }
    }

}