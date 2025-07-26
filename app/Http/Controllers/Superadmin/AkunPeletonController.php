<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkunPeletonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = \App\Models\User::all();
        return view('superadmin.akunpeleton.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.akunpeleton.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:superadmin,peleton',  
        ]);
    
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'], 
        ]);
    
        return redirect()->route('akunpeleton.index')->with([
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
        $user = \App\Models\User::findOrFail($id); 
        return view('superadmin.akunpeleton.show', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = \App\Models\user::findOrFail($id);
        $user->update($request->all()); 
    
        return redirect()->route('akunpeleton.index')->with([
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'warning'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete(); 
    
        return redirect()->route('akunpeleton.index')->with([
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'danger'
        ]);
    }
}