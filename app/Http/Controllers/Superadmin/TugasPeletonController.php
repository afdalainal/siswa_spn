<?php
namespace App\Http\Controllers\Superadmin;

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

class TugasPeletonController extends Controller
{
    public function index()
    {
        $tugaspeleton = TugasPeleton::withTrashed()
            ->with(['pengasuhDanton', 'pengasuhDanki', 'pengasuhDanmen', 'peleton'])
            ->get();
    
        return view('superadmin.tugaspeleton.index', compact('tugaspeleton'));
    }
    
    public function create()
    {
        $pengasuh = Pengasuh::all();
        $user = User::all();
        $siswa = Siswa::all();
        $tugasSiswaStatus = TugasSiswa::where('status', 'aktif')
                            ->pluck('status', 'siswa_id')->toArray();
        
        return view('superadmin.tugaspeleton.create', compact('pengasuh', 'user', 'siswa', 'tugasSiswaStatus'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengasuh_danton_id' => 'required|exists:pengasuhs,id',
            'pengasuh_danki_id' => 'required|exists:pengasuhs,id',
            'pengasuh_danmen_id' => 'required|exists:pengasuhs,id',
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'exists:siswas,id',
            'ton_ki_yon' => 'required|string',
            'minggu_ke' => 'required|string',
            'hari_tgl_1' => 'required|string',
            'tempat_1' => 'required|string',
            'hari_tgl_2' => 'required|string',
            'tempat_2' => 'required|string',
            'hari_tgl_3' => 'required|string',
            'tempat_3' => 'required|string',
            'hari_tgl_4' => 'required|string',
            'tempat_4' => 'required|string',
            'hari_tgl_5' => 'required|string',
            'tempat_5' => 'required|string',
            'hari_tgl_6' => 'required|string',
            'tempat_6' => 'required|string',
            'hari_tgl_7' => 'required|string',
            'tempat_7' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $tugasPeleton = TugasPeleton::create([
                'pengasuh_danton_id' => $validated['pengasuh_danton_id'],
                'pengasuh_danki_id' => $validated['pengasuh_danki_id'],
                'pengasuh_danmen_id' => $validated['pengasuh_danmen_id'],
                'user_id' => $validated['user_id'],
                'ton_ki_yon' => $validated['ton_ki_yon'],
                'minggu_ke' => $validated['minggu_ke'],
                'hari_tgl_1' => $validated['hari_tgl_1'],
                'tempat_1' => $validated['tempat_1'],
                'hari_tgl_2' => $validated['hari_tgl_2'],
                'tempat_2' => $validated['tempat_2'],
                'hari_tgl_3' => $validated['hari_tgl_3'],
                'tempat_3' => $validated['tempat_3'],
                'hari_tgl_4' => $validated['hari_tgl_4'],
                'tempat_4' => $validated['tempat_4'],
                'hari_tgl_5' => $validated['hari_tgl_5'],
                'tempat_5' => $validated['tempat_5'],
                'hari_tgl_6' => $validated['hari_tgl_6'],
                'tempat_6' => $validated['tempat_6'],
                'hari_tgl_7' => $validated['hari_tgl_7'],
                'tempat_7' => $validated['tempat_7'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['siswa_id'] as $siswaId) {
                // Create new tugas for the peleton
                $tugasSiswa = TugasSiswa::create([
                    'tugas_peleton_id' => $tugasPeleton->id,
                    'siswa_id' => $siswaId,
                    'status' => 'aktif',
                ]);

                // Create related records
                PenilaianPengamatan::create(['tugas_siswa_id' => $tugasSiswa->id]);
                PenilaianHarian::create(['tugas_siswa_id' => $tugasSiswa->id]);
                PenilaianMingguan::create(['tugas_siswa_id' => $tugasSiswa->id]);
            }

            DB::commit();

            return redirect()->route('tugaspeleton.index')->with([
                'message' => 'Tugas Peleton berhasil disimpan!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $tugaspeleton = TugasPeleton::with(['tugasSiswa', 'siswa'])->findOrFail($id);
        $pengasuh = Pengasuh::all();
        $user = User::all();
        $siswa = Siswa::all();
        $tugasSiswaStatus = TugasSiswa::where('status', 'aktif')
                            ->pluck('status', 'siswa_id')->toArray();
        
        return view('superadmin.tugaspeleton.show', compact(
            'tugaspeleton', 
            'pengasuh', 
            'user', 
            'siswa', 
            'tugasSiswaStatus'
        ));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pengasuh_danton_id' => 'required|exists:pengasuhs,id',
            'pengasuh_danki_id' => 'required|exists:pengasuhs,id',
            'pengasuh_danmen_id' => 'required|exists:pengasuhs,id',
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'exists:siswas,id',
            'ton_ki_yon' => 'required|string',
            'minggu_ke' => 'required|string',
            'hari_tgl_1' => 'required|string',
            'tempat_1' => 'required|string',
            'hari_tgl_2' => 'required|string',
            'tempat_2' => 'required|string',
            'hari_tgl_3' => 'required|string',
            'tempat_3' => 'required|string',
            'hari_tgl_4' => 'required|string',
            'tempat_4' => 'required|string',
            'hari_tgl_5' => 'required|string',
            'tempat_5' => 'required|string',
            'hari_tgl_6' => 'required|string',
            'tempat_6' => 'required|string',
            'hari_tgl_7' => 'required|string',
            'tempat_7' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $tugasPeleton = TugasPeleton::findOrFail($id);
            
            $tugasPeleton->update([
                'pengasuh_danton_id' => $validated['pengasuh_danton_id'],
                'pengasuh_danki_id' => $validated['pengasuh_danki_id'],
                'pengasuh_danmen_id' => $validated['pengasuh_danmen_id'],
                'user_id' => $validated['user_id'],
                'ton_ki_yon' => $validated['ton_ki_yon'],
                'minggu_ke' => $validated['minggu_ke'],
                'hari_tgl_1' => $validated['hari_tgl_1'],
                'tempat_1' => $validated['tempat_1'],
                'hari_tgl_2' => $validated['hari_tgl_2'],
                'tempat_2' => $validated['tempat_2'],
                'hari_tgl_3' => $validated['hari_tgl_3'],
                'tempat_3' => $validated['tempat_3'],
                'hari_tgl_4' => $validated['hari_tgl_4'],
                'tempat_4' => $validated['tempat_4'],
                'hari_tgl_5' => $validated['hari_tgl_5'],
                'tempat_5' => $validated['tempat_5'],
                'hari_tgl_6' => $validated['hari_tgl_6'],
                'tempat_6' => $validated['tempat_6'],
                'hari_tgl_7' => $validated['hari_tgl_7'],
                'tempat_7' => $validated['tempat_7'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Get current students in this peleton
            $currentSiswaIds = $tugasPeleton->tugasSiswa->pluck('siswa_id')->toArray();
            $newSiswaIds = $validated['siswa_id'];

            // Students to be removed
            $removedSiswaIds = array_diff($currentSiswaIds, $newSiswaIds);
            if (!empty($removedSiswaIds)) {
                TugasSiswa::where('tugas_peleton_id', $tugasPeleton->id)
                    ->whereIn('siswa_id', $removedSiswaIds)
                    ->update(['status' => 'nonaktif']);
            }

            // Students to be added
            $addedSiswaIds = array_diff($newSiswaIds, $currentSiswaIds);
            foreach ($addedSiswaIds as $siswaId) {
                // Set any existing active tugas to nonaktif
                TugasSiswa::where('siswa_id', $siswaId)
                    ->update(['status' => 'nonaktif']);

                // Create new tugas
                $tugasSiswa = TugasSiswa::create([
                    'tugas_peleton_id' => $tugasPeleton->id,
                    'siswa_id' => $siswaId,
                    'status' => 'aktif',
                ]);

                // Create related records
                PenilaianPengamatan::create(['tugas_siswa_id' => $tugasSiswa->id]);
                PenilaianHarian::create(['tugas_siswa_id' => $tugasSiswa->id]);
                PenilaianMingguan::create(['tugas_siswa_id' => $tugasSiswa->id]);
            }

            // Students that remain (update if needed)
            $remainingSiswaIds = array_intersect($currentSiswaIds, $newSiswaIds);
            if (!empty($remainingSiswaIds)) {
                TugasSiswa::where('tugas_peleton_id', $tugasPeleton->id)
                    ->whereIn('siswa_id', $remainingSiswaIds)
                    ->update(['status' => 'aktif']);
            }

            DB::commit();

            return redirect()->route('tugaspeleton.index')->with([
                'message' => 'Tugas Peleton berhasil diperbarui!',
                'alert-type' => 'warning'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $tugasPeleton = TugasPeleton::with(['tugasSiswa.penilaianHarian', 'tugasSiswa.penilaianMingguan', 'tugasSiswa.penilaianPengamatan'])
            ->withTrashed()
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($tugasPeleton->tugasSiswa as $siswa) {
                $siswa->penilaianHarian()->delete();
                $siswa->penilaianMingguan()->delete();
                $siswa->penilaianPengamatan()->delete();
                $siswa->forceDelete();
            }

            $tugasPeleton->forceDelete();
            DB::commit();

            return redirect()->route('tugaspeleton.index')->with([
                'message' => 'Data berhasil dihapus permanen!',
                'alert-type' => 'danger'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal hapus data: ' . $e->getMessage());
        }
    }

    public function softdelete($id)
    {
        $tugasPeleton = TugasPeleton::findOrFail($id);
        $tugasPeleton->delete(); 

        return redirect()->route('tugaspeleton.index')
            ->with(['message' => 'Data berhasil dinonaktifkan', 'alert-type' => 'danger']);
    }

    public function restore($id)
    {
        $tugasPeleton = TugasPeleton::withTrashed()->findOrFail($id);
    
        if ($tugasPeleton->trashed()) {
            $tugasPeleton->restore();
    
            return redirect()->route('tugaspeleton.index')
                ->with(['message' => 'Data berhasil diaktifkan kembali', 'alert-type' => 'success']);
        }
    
        return redirect()->route('tugaspeleton.index')
            ->with(['message' => 'Data sudah aktif', 'alert-type' => 'info']);
    }
}