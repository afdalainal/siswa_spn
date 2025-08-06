<?php

namespace App\Http\Controllers\Peleton;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TugasPeleton;
use App\Models\TugasSiswa;
use App\Models\PenilaianPengamatan;
use App\Models\PenilaianHarian;
use App\Models\PenilaianMingguan;
use App\Models\PenilaianSiswaHarian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get current tugas peleton for this user
        $currentTugas = TugasPeleton::with(['pengasuhDanton', 'pengasuhDanki', 'pengasuhDanmen'])
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        // Get all tugas peleton for this user (for history)
        $allTugas = TugasPeleton::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get siswa count for current tugas
        $siswaCount = 0;
        $penilaianStatus = [];
        $averageScores = [];

        if ($currentTugas) {
            $siswaCount = TugasSiswa::where('tugas_peleton_id', $currentTugas->id)
                ->where('status', 'aktif')
                ->count();

            // Get penilaian status (how many days have been assessed)
            $penilaianStatus = PenilaianSiswaHarian::selectRaw('hari_ke, COUNT(*) as count')
                ->whereIn('tugas_siswa_id', function($query) use ($currentTugas) {
                    $query->select('id')
                        ->from('tugas_siswas')
                        ->where('tugas_peleton_id', $currentTugas->id);
                })
                ->groupBy('hari_ke')
                ->get()
                ->pluck('count', 'hari_ke');

            // Get average scores for each day
            $averageScores = PenilaianPengamatan::selectRaw('penilaian_siswa_harian_id, AVG(nilai_akhir) as average')
                ->whereIn('penilaian_siswa_harian_id', function($query) use ($currentTugas) {
                    $query->select('penilaian_siswa_harians.id')
                        ->from('penilaian_siswa_harians')
                        ->join('tugas_siswas', 'tugas_siswas.id', '=', 'penilaian_siswa_harians.tugas_siswa_id')
                        ->where('tugas_siswas.tugas_peleton_id', $currentTugas->id);
                })
                ->groupBy('penilaian_siswa_harian_id')
                ->with(['penilaianSiswaHarian' => function($query) {
                    $query->select('id', 'hari_ke');
                }])
                ->get()
                ->groupBy(function($item) {
                    return $item->penilaianSiswaHarian->hari_ke;
                })
                ->map(function($group) {
                    return $group->avg('average');
                });
        }

        return view('peleton.dashboard', compact(
            'currentTugas',
            'allTugas',
            'siswaCount',
            'penilaianStatus',
            'averageScores'
        ));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}