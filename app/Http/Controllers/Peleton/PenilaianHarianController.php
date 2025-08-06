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

class PenilaianHarianController extends Controller
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
    
        return view('peleton.penilaianharian.index', compact('tugaspeleton'));
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
            ->with(['tugasSiswa.siswa', 'tugasSiswa.penilaianharian'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $tugasSiswa = $tugasPeleton->tugasSiswa;
    
        return view('peleton.penilaianharian.listpenilaian', compact('tugasSiswa', 'tugasPeleton'));
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penilaianharian = PenilaianHarian::with('tugasSiswa.tugasPeleton', 'tugasSiswa.siswa')
            ->findOrFail($id);
    
        if (
            !$penilaianharian->tugasSiswa ||
            !$penilaianharian->tugasSiswa->tugasPeleton ||
            $penilaianharian->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }
    
        return view('peleton.penilaianharian.show', compact('penilaianharian'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nilai_harian_1' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_harian_2' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_harian_3' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_harian_4' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_harian_5' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_harian_6' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'nilai_harian_7' => 'nullable|numeric|between:-99999999.99,99999999.99',
            'keterangan' => 'nullable|string',
        ]);

        $penilaian = PenilaianHarian::with(['tugasSiswa.tugasPeleton', 'tugasSiswa.siswa'])
            ->findOrFail($id);
    
        if (
            !$penilaian->tugasSiswa ||
            !$penilaian->tugasSiswa->tugasPeleton ||
            $penilaian->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data ini.');
        }
    
        $penilaian->update($request->only([
            'nilai_harian_1',
            'nilai_harian_2',
            'nilai_harian_3',
            'nilai_harian_4',
            'nilai_harian_5',
            'nilai_harian_6',
            'nilai_harian_7',
            'keterangan',
        ]));
    
        return redirect()->route('penilaianharian.index')->with([
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

    public function laporan(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with([
                'tugasSiswa.siswa', 
                'tugasSiswa.penilaianHarian',
                'pengasuhDanton',
                'pengasuhDanki',
                'pengasuhDanmen'
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $tugasSiswa = $tugasPeleton->tugasSiswa;

        if (request()->has('download')) {
            $pdf = Pdf::loadView('peleton.penilaianharian.laporan', compact('tugasSiswa', 'tugasPeleton'))
                      ->setPaper('a4', 'landscape');
            
            return $pdf->stream('laporan-penilaian-harian.pdf');
        }

        return view('peleton.penilaianharian.laporan', compact('tugasSiswa', 'tugasPeleton'));
    }

    public function grafik(string $id)
    {
        $tugasPeleton = TugasPeleton::with([
                'tugasSiswa' => function($query) {
                    $query->with([
                        'siswa:id,nama,nosis',
                        'penilaianHarian'
                    ]);
                },
                'pengasuhDanton:id,nama',
                'pengasuhDanki:id,nama',
                'pengasuhDanmen:id,nama'
            ])
            ->withTrashed()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        // Prepare chart data structure
        $chartData = [
            'days' => ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'],
            'students' => [],
            'nilaiHarianData' => [],
            'nilaiRataRataData' => [],
            'progressHarianData' => [],
            'trendAnalysisData' => []
        ];
    
        // Get all students with their daily assessments
        foreach ($tugasPeleton->tugasSiswa as $tugasSiswa) {
            $studentName = $tugasSiswa->siswa->nama;
            $chartData['students'][] = $studentName;
            
            // Get penilaian harian data
            $penilaianHarian = $tugasSiswa->penilaianHarian;
            
            if ($penilaianHarian) {
                // Initialize arrays for this student
                $studentNilaiHarian = [];
                $studentProgressHarian = [];
                $previousValue = null;
                
                // Loop through 7 days to get daily scores
                for ($hari = 1; $hari <= 7; $hari++) {
                    $nilaiField = 'nilai_harian_' . $hari;
                    $nilaiHarian = $penilaianHarian->$nilaiField ?? 0;
                    
                    $studentNilaiHarian[] = round($nilaiHarian, 2);
                    
                    // Calculate progress (difference from previous day)
                    if ($previousValue !== null && $nilaiHarian > 0) {
                        $progress = $nilaiHarian - $previousValue;
                        $studentProgressHarian[] = round($progress, 2);
                    } else {
                        $studentProgressHarian[] = 0;
                    }
                    
                    if ($nilaiHarian > 0) {
                        $previousValue = $nilaiHarian;
                    }
                }
                
                // Add student data to chart data
                $chartData['nilaiHarianData'][] = [
                    'name' => $studentName,
                    'data' => $studentNilaiHarian
                ];
                
                $chartData['progressHarianData'][] = [
                    'name' => $studentName,
                    'data' => $studentProgressHarian
                ];
                
                // Calculate average score
                $validScores = array_filter($studentNilaiHarian, function($score) {
                    return $score > 0;
                });
                
                $averageScore = !empty($validScores) ? round(array_sum($validScores) / count($validScores), 2) : 0;
                
                $chartData['nilaiRataRataData'][] = [
                    'name' => $studentName,
                    'score' => $averageScore
                ];
                
                // Trend analysis data (average, min, max per student)
                if (!empty($validScores)) {
                    $chartData['trendAnalysisData'][] = [
                        'name' => $studentName,
                        'average' => round(array_sum($validScores) / count($validScores), 2),
                        'min' => round(min($validScores), 2),
                        'max' => round(max($validScores), 2),
                        'consistency' => round((1 - (max($validScores) - min($validScores)) / max($validScores)) * 100, 1)
                    ];
                } else {
                    $chartData['trendAnalysisData'][] = [
                        'name' => $studentName,
                        'average' => 0,
                        'min' => 0,
                        'max' => 0,
                        'consistency' => 0
                    ];
                }
                
            } else {
                // If no assessment data, add empty/zero values
                $chartData['nilaiHarianData'][] = [
                    'name' => $studentName,
                    'data' => [0, 0, 0, 0, 0, 0, 0]
                ];
                
                $chartData['progressHarianData'][] = [
                    'name' => $studentName,
                    'data' => [0, 0, 0, 0, 0, 0, 0]
                ];
                
                $chartData['nilaiRataRataData'][] = [
                    'name' => $studentName,
                    'score' => 0
                ];
                
                $chartData['trendAnalysisData'][] = [
                    'name' => $studentName,
                    'average' => 0,
                    'min' => 0,
                    'max' => 0,
                    'consistency' => 0
                ];
            }
        }
    
        return view('peleton.penilaianharian.grafik', [
            'chartData' => $chartData,
            'tugasPeleton' => $tugasPeleton
        ]);
    }
    
}