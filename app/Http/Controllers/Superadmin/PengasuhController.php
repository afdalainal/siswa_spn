<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengasuhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengasuh = \App\Models\Pengasuh::all();
        return view('superadmin.pengasuh.index', compact('pengasuh'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.pengasuh.create');
        
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
        \App\Models\Pengasuh::create([
            'jabatan' => $validated['jabatan'],
            'nama' => $validated['nama'],
            'pangkat_nrp' => $validated['pangkat_nrp'],
        ]);
        return redirect()->route('pengasuh.index')->with([
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
        $pengasuh = \App\Models\Pengasuh::findOrFail($id); 
        return view('superadmin.pengasuh.show', compact('pengasuh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengasuh = \App\Models\Pengasuh::findOrFail($id);
        $pengasuh->update($request->all()); 
    
        return redirect()->route('pengasuh.index')->with([
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'warning'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengasuh = \App\Models\Pengasuh::findOrFail($id);
        $pengasuh->delete(); 
    
        return redirect()->route('pengasuh.index')->with([
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'danger'
        ]);
    }
}