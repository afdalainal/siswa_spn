<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = \App\Models\Anggota::all();
        return view('superadmin.anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.anggota.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        \App\Models\Anggota::create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil disubmit!');
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
        $anggota = \App\Models\Anggota::findOrFail($id); 
        return view('superadmin.anggota.show', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        $anggota->update($request->all()); 
    
        return redirect()->route('anggota.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        $anggota->delete(); 
    
        return redirect()->route('anggota.index')->with('success', 'Data berhasil dihapus');
    }
}