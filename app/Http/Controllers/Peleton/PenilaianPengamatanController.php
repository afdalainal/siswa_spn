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

    public function grafik(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with(['tugasSiswa.siswa', 'tugasSiswa.penilaianPengamatan'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $tugasSiswa = $tugasPeleton->tugasSiswa;

        $grafikData = [];
        foreach ($tugasSiswa as $siswa) {
            if ($siswa->penilaianPengamatan) {
                $grafikData[] = [
                    'nama_siswa' => $siswa->siswa->nama,
                    'nilai_akhir' => $siswa->penilaianPengamatan->nilai_akhir,
                    'nilai_konversi' => $siswa->penilaianPengamatan->nilai_konversi,
                    'skor' => $siswa->penilaianPengamatan->skor,
                    'rank_harian' => $siswa->penilaianPengamatan->rank_harian
                ];
            }
        }
        return view('peleton.penilaianpengamatan.grafik', compact('tugasPeleton', 'grafikData'));
    }


    public function laporan(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with([
                'tugasSiswa.siswa', 
                'tugasSiswa.penilaianPengamatan',
                'pengasuhDanton',
                'pengasuhDanki',
                'pengasuhDanmen'
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        $tugasSiswa = $tugasPeleton->tugasSiswa;
    
        // Jika request ingin mendapatkan PDF
        if (request()->has('download')) {
            $pdf = Pdf::loadView('peleton.penilaianpengamatan.laporan', compact('tugasSiswa', 'tugasPeleton'))
                      ->setPaper('a4', 'landscape');
            
            return $pdf->stream('laporan-penilaian-pengamatan.pdf');
        }
    
        return view('peleton.penilaianpengamatan.laporan', compact('tugasSiswa', 'tugasPeleton'));
    }

}