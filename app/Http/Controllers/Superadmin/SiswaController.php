<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = \App\Models\Siswa::all();
        return view('superadmin.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.siswa.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nosis' => 'required|string|max:255',
        ]);
        \App\Models\Siswa::create([
            'nama' => $validated['nama'],
            'nosis' => $validated['nosis'],
        ]);
        return redirect()->route('siswa.index')->with([
            'message' => 'Data berhasil disimpan!',
            'alert-type' => 'success'
        ]);
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
    public function edit($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id); 
        return view('superadmin.siswa.show', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        $siswa->update($request->all()); 
    
        return redirect()->route('siswa.index')->with([
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'warning'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        $siswa->delete(); 
    
        return redirect()->route('siswa.index')->with([
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'danger'
        ]);
    }
}