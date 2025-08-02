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
    
        if (request()->has('download')) {
            $pdf = Pdf::loadView('peleton.penilaianmingguan.laporan', compact('tugasSiswa', 'tugasPeleton'))
                      ->setPaper('a4', 'landscape');
            
            return $pdf->stream('laporan-penilaian-mingguan.pdf');
        }

        return view('peleton.penilaianmingguan.laporan', compact('tugasSiswa', 'tugasPeleton'));
    }

}