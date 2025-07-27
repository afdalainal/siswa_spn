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
        return view('superadmin.tugaspeleton.create', compact('pengasuh', 'user','siswa'));
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
            $tugasSiswa = TugasSiswa::create([
                'tugas_peleton_id' => $tugasPeleton->id,
                'siswa_id' => $siswaId,
                'status' => 'aktif',
            ]);
    
            PenilaianPengamatan::create([
                'tugas_siswa_id' => $tugasSiswa->id,
            ]);
    
            PenilaianHarian::create([
                'tugas_siswa_id' => $tugasSiswa->id,
            ]);
    
            PenilaianMingguan::create([
                'tugas_siswa_id' => $tugasSiswa->id,
            ]);
        }
    
        return redirect()->route('tugaspeleton.index')->with([
            'message' => 'Tugas Peleton dan siswa berhasil disimpan!',
            'alert-type' => 'success'
        ]);
    }

    public function edit($id)
    {
      $tugaspeleton = TugasPeleton::with('tugasSiswa')->findOrFail($id);
      return view('superadmin.tugaspeleton.show', [
        'tugaspeleton' => $tugaspeleton,
        'pengasuh' => Pengasuh::all(),
        'user' => User::all(),
        'siswas' => Siswa::all(),
        'siswa_terkait' => $tugaspeleton->tugasSiswa,
        'siswa_ids_aktif' => $tugaspeleton->tugasSiswa()->where('status','aktif')->pluck('siswa_id')->toArray(),
      ]);
    }

    public function update(Request $request, $id)
    {
      $tugaspeleton = TugasPeleton::with('tugasSiswa')->findOrFail($id);
  
      $validated = $request->validate([
        'pengasuh_danton_id' => 'required|exists:pengasuhs,id',
        'pengasuh_danki_id'   => 'required|exists:pengasuhs,id',
        'pengasuh_danmen_id'  => 'required|exists:pengasuhs,id',
        'user_id'             => 'required|exists:users,id',
        'siswa_id'            => 'required|array',
        'siswa_id.*'          => 'exists:siswas,id',
        'ton_ki_yon','minggu_ke','hari_tgl_1','tempat_1','hari_tgl_2','tempat_2','hari_tgl_3',
        'tempat_3','hari_tgl_4','tempat_4','hari_tgl_5','tempat_5','hari_tgl_6','tempat_6',
        'hari_tgl_7','tempat_7','keterangan'
      ]);
      // map fillable as needed...
  
      DB::beginTransaction();
      try {
        $tugaspeleton->update($validated);
  
        $selSiswa = collect($validated['siswa_id']);
        $lama = $tugaspeleton->tugasSiswa->pluck('siswa_id');
  
        // Tambah siswa baru
        foreach ($selSiswa->diff($lama) as $sId) {
          $ts = TugasSiswa::create([
            'tugas_peleton_id' => $tugaspeleton->id,
            'siswa_id' => $sId,
            'status' => 'aktif',
          ]);
          PenilaianPengamatan::create(['tugas_siswa_id' => $ts->id]);
          PenilaianHarian::create(['tugas_siswa_id' => $ts->id]);
          PenilaianMingguan::create(['tugas_siswa_id' => $ts->id]);
        }
  
        // Aktifkan kembali
        TugasSiswa::where('tugas_peleton_id', $tugaspeleton->id)
          ->whereIn('siswa_id', $selSiswa->intersect($lama))
          ->update(['status' => 'aktif']);
  
        // Nonaktifkan yang dilepas
        TugasSiswa::where('tugas_peleton_id', $tugaspeleton->id)
          ->whereIn('siswa_id', $lama->diff($selSiswa))
          ->update(['status' => 'nonaktif']);
  
        DB::commit();
        return redirect()->route('tugaspeleton.index')
          ->with(['message'=>'Data berhasil diperbarui','alert-type'=>'success']);
      } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors('Update gagal: ' . $e->getMessage());
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
            $siswa->forceDelete(); // hard delete
        }

        $tugasPeleton->forceDelete(); // hapus permanen
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