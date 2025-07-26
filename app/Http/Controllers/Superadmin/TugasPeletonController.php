<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TugasPeletonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugaspeleton = \App\Models\TugasPeleton::all();
        return view('superadmin.tugaspeleton.index', compact('tugaspeleton'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.tugaspeleton.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'pangkat_nrp' => 'required|string|max:255',
        ]);
        \App\Models\TugasPeleton::create([
            'jabatan' => $validated['jabatan'],
            'nama' => $validated['nama'],
            'pangkat_nrp' => $validated['pangkat_nrp'],
        ]);
        return redirect()->route('tugaspeleton.index')->with([
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
        $tugaspeleton = \App\Models\TugasPeleton::findOrFail($id); 
        return view('superadmin.tugaspeleton.show', compact('tugaspeleton'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tugaspeleton = \App\Models\TugasPeleton::findOrFail($id);
        $tugaspeleton->update($request->all()); 
    
        return redirect()->route('tugaspeleton.index')->with([
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'warning'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tugaspeleton = \App\Models\TugasPeleton::findOrFail($id);
        $tugaspeleton->delete(); 
    
        return redirect()->route('tugaspeleton.index')->with([
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'danger'
        ]);
    }
}