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
use App\Models\PenilaianSiswaHarian;

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
        // dd($request->all());
        $validated = $request->validate([
            'pengasuh_danton_id' => 'required|exists:pengasuhs,id',
            'pengasuh_danki_id' => 'required|exists:pengasuhs,id',
            'pengasuh_danmen_id' => 'required|exists:pengasuhs,id',
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|array|min:1',
            'siswa_id.*' => 'exists:siswas,id',
            'ton_ki_yon' => 'required|string|max:255',
            'minggu_ke' => 'required|string|max:255',
            'hari_tgl_1' => 'required|string|max:255',
            'tempat_1' => 'required|string|max:255',
            'hari_tgl_2' => 'required|string|max:255',
            'tempat_2' => 'required|string|max:255',
            'hari_tgl_3' => 'required|string|max:255',
            'tempat_3' => 'required|string|max:255',
            'hari_tgl_4' => 'required|string|max:255',
            'tempat_4' => 'required|string|max:255',
            'hari_tgl_5' => 'required|string|max:255',
            'tempat_5' => 'required|string|max:255',
            'hari_tgl_6' => 'required|string|max:255',
            'tempat_6' => 'required|string|max:255',
            'hari_tgl_7' => 'required|string|max:255',
            'tempat_7' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan data tugas peleton
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

            // 2. Simpan siswa yang terlibat
            foreach ($validated['siswa_id'] as $siswaId) {
                // Simpan tugas siswa
                $tugasSiswa = TugasSiswa::create([
                    'tugas_peleton_id' => $tugasPeleton->id,
                    'siswa_id' => $siswaId,
                    'status' => 'aktif',
                ]);

                // 3. Buat 7 penilaian harian untuk setiap siswa
                for ($hariKe = 1; $hariKe <= 7; $hariKe++) {
                    $penilaianHarian = PenilaianSiswaHarian::create([
                        'tugas_siswa_id' => $tugasSiswa->id,
                        'hari_ke' => $hariKe,
                    ]);

                    // 4. Buat record penilaian untuk setiap hari
                    PenilaianPengamatan::create(['penilaian_siswa_harian_id' => $penilaianHarian->id]);
                    PenilaianHarian::create(['penilaian_siswa_harian_id' => $penilaianHarian->id]);
                    PenilaianMingguan::create(['penilaian_siswa_harian_id' => $penilaianHarian->id]);
                }
            }

            DB::commit();

            return redirect()->route('tugaspeleton.index')
                ->with([
                    'message' => 'Tugas Peleton berhasil dibuat!',
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
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
            'siswa_id' => 'required|array|min:1',
            'siswa_id.*' => 'exists:siswas,id',
            'ton_ki_yon' => 'required|string|max:255',
            'minggu_ke' => 'required|string|max:255',
            'hari_tgl_1' => 'required|string|max:255',
            'tempat_1' => 'required|string|max:255',
            'hari_tgl_2' => 'required|string|max:255',
            'tempat_2' => 'required|string|max:255',
            'hari_tgl_3' => 'required|string|max:255',
            'tempat_3' => 'required|string|max:255',
            'hari_tgl_4' => 'required|string|max:255',
            'tempat_4' => 'required|string|max:255',
            'hari_tgl_5' => 'required|string|max:255',
            'tempat_5' => 'required|string|max:255',
            'hari_tgl_6' => 'required|string|max:255',
            'tempat_6' => 'required|string|max:255',
            'hari_tgl_7' => 'required|string|max:255',
            'tempat_7' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
    
        DB::beginTransaction();
        try {
            $tugasPeleton = TugasPeleton::findOrFail($id);
            
            // 1. Update data tugas peleton
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
    
            // 2. Get current and new student assignments
            $currentSiswaIds = $tugasPeleton->tugasSiswa->pluck('siswa_id')->toArray();
            $newSiswaIds = $validated['siswa_id'];
    
            // 3. Handle removed students (set to nonaktif)
            $removedSiswaIds = array_diff($currentSiswaIds, $newSiswaIds);
            if (!empty($removedSiswaIds)) {
                TugasSiswa::where('tugas_peleton_id', $tugasPeleton->id)
                    ->whereIn('siswa_id', $removedSiswaIds)
                    ->update(['status' => 'nonaktif']);
            }
    
            // 4. Handle added students
            $addedSiswaIds = array_diff($newSiswaIds, $currentSiswaIds);
            foreach ($addedSiswaIds as $siswaId) {
                // Create new assignment
                $tugasSiswa = TugasSiswa::create([
                    'tugas_peleton_id' => $tugasPeleton->id,
                    'siswa_id' => $siswaId,
                    'status' => 'aktif',
                ]);
    
                // Create 7 daily assessments for new student
                for ($hariKe = 1; $hariKe <= 7; $hariKe++) {
                    $penilaianHarian = PenilaianSiswaHarian::create([
                        'tugas_siswa_id' => $tugasSiswa->id,
                        'hari_ke' => $hariKe,
                    ]);
    
                    // Create assessment records
                    PenilaianPengamatan::create(['penilaian_siswa_harian_id' => $penilaianHarian->id]);
                    PenilaianHarian::create(['penilaian_siswa_harian_id' => $penilaianHarian->id]);
                    PenilaianMingguan::create(['penilaian_siswa_harian_id' => $penilaianHarian->id]);
                }
            }
    
            // 5. Handle remaining students (keep active)
            $remainingSiswaIds = array_intersect($currentSiswaIds, $newSiswaIds);
            if (!empty($remainingSiswaIds)) {
                TugasSiswa::where('tugas_peleton_id', $tugasPeleton->id)
                    ->whereIn('siswa_id', $remainingSiswaIds)
                    ->update(['status' => 'aktif']);
            }
    
            DB::commit();
    
            return redirect()->route('tugaspeleton.index')->with([
                'message' => 'Tugas Peleton berhasil diperbarui!',
                'alert-type' => 'success'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating tugas peleton: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $tugasPeleton = TugasPeleton::with([
            'tugasSiswa.penilaianSiswaHarian.penilaianPengamatan',
            'tugasSiswa.penilaianSiswaHarian.penilaianHarian',
            'tugasSiswa.penilaianSiswaHarian.penilaianMingguan'
        ])->withTrashed()->findOrFail($id);
    
        DB::beginTransaction();
        try {
            foreach ($tugasPeleton->tugasSiswa as $tugasSiswa) {
                // Hapus semua penilaian harian beserta relasinya
                foreach ($tugasSiswa->penilaianSiswaHarian as $penilaianHarian) {
                    // Hapus penilaian terkait
                    $penilaianHarian->penilaianPengamatan()->delete();
                    $penilaianHarian->penilaianHarian()->delete();
                    $penilaianHarian->penilaianMingguan()->delete();
                    
                    // Hapus penilaian harian itu sendiri
                    $penilaianHarian->delete();
                }
                
                // Hapus tugas siswa
                $tugasSiswa->forceDelete();
            }
    
            // Hapus permanen tugas peleton
            $tugasPeleton->forceDelete();
    
            DB::commit();
    
            return redirect()->route('tugaspeleton.index')->with([
                'message' => 'Data berhasil dihapus permanen!',
                'alert-type' => 'success'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting tugas peleton: ' . $e->getMessage());
            return back()->withErrors('Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function softdelete($id)
    {
        $tugasPeleton = TugasPeleton::with(['tugasSiswa'])->findOrFail($id);
    
        DB::beginTransaction();
        try {
            // Nonaktifkan semua tugas siswa terkait
            $tugasPeleton->tugasSiswa()->update(['status' => 'nonaktif']);
            
            // Soft delete tugas peleton
            $tugasPeleton->delete();
    
            DB::commit();
    
            return redirect()->route('tugaspeleton.index')->with([
                'message' => 'Data berhasil dinonaktifkan',
                'alert-type' => 'warning'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error soft deleting tugas peleton: ' . $e->getMessage());
            return back()->withErrors('Gagal menonaktifkan data: ' . $e->getMessage());
        }
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