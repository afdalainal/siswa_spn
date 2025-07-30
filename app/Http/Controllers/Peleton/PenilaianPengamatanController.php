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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with(['tugasSiswa.siswa', 'tugasSiswa.penilaianPengamatan'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $tugasSiswa = $tugasPeleton->tugasSiswa;
    
        return view('peleton.penilaianpengamatan.listpenilaian', compact('tugasSiswa', 'tugasPeleton'));
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penilaianpengamatan = PenilaianPengamatan::with('tugasSiswa.tugasPeleton', 'tugasSiswa.siswa')
            ->findOrFail($id);
    
        if (
            !$penilaianpengamatan->tugasSiswa ||
            !$penilaianpengamatan->tugasSiswa->tugasPeleton ||
            $penilaianpengamatan->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }
    
        return view('peleton.penilaianpengamatan.show', compact('penilaianpengamatan'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penilaian = PenilaianPengamatan::with(['tugasSiswa.tugasPeleton', 'tugasSiswa.siswa'])
            ->findOrFail($id);
    
        if (
            !$penilaian->tugasSiswa ||
            !$penilaian->tugasSiswa->tugasPeleton ||
            $penilaian->tugasSiswa->tugasPeleton->user_id !== auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data ini.');
        }
    
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
    
        return redirect()->route('penilaianpengamatan.index')->with([
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
}