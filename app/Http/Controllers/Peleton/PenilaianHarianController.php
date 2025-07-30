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

    public function grafik(string $id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()
            ->with(['tugasSiswa.siswa', 'tugasSiswa.penilaianHarian'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $tugasSiswa = $tugasPeleton->tugasSiswa;

        $grafikData = [];
        foreach ($tugasSiswa as $siswa) {
            if ($siswa->penilaianHarian) {
                $grafikData[] = [
                    'nama_siswa' => $siswa->siswa->nama,
                    'nilai_harian_1' => $siswa->penilaianHarian->nilai_harian_1,
                    'nilai_harian_2' => $siswa->penilaianHarian->nilai_harian_2,
                    'nilai_harian_3' => $siswa->penilaianHarian->nilai_harian_3,
                    'nilai_harian_4' => $siswa->penilaianHarian->nilai_harian_4,
                    'nilai_harian_5' => $siswa->penilaianHarian->nilai_harian_5,
                    'nilai_harian_6' => $siswa->penilaianHarian->nilai_harian_6,
                    'nilai_harian_7' => $siswa->penilaianHarian->nilai_harian_7,
                    'rata_rata' => (
                        $siswa->penilaianHarian->nilai_harian_1 +
                        $siswa->penilaianHarian->nilai_harian_2 +
                        $siswa->penilaianHarian->nilai_harian_3 +
                        $siswa->penilaianHarian->nilai_harian_4 +
                        $siswa->penilaianHarian->nilai_harian_5 +
                        $siswa->penilaianHarian->nilai_harian_6 +
                        $siswa->penilaianHarian->nilai_harian_7
                    ) / 7
                ];
            }
        }

        return view('peleton.penilaianharian.grafik', compact('tugasPeleton', 'grafikData'));
    }
    
}