<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Pengasuh;
use App\Models\TugasPeleton;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // User statistics
        $userStats = [
            'total' => User::count(),
            'superadmin' => User::where('role', 'superadmin')->count(),
            'peleton' => User::where('role', 'peleton')->count(),
        ];

        // Student statistics
        $siswaStats = [
            'total' => Siswa::count(),
            'active' => TugasPeleton::activeStudentsCount(),
        ];

        // Pengasuh statistics
        $pengasuhStats = Pengasuh::count();

        // Recent peleton assignments
        $recentTugas = TugasPeleton::with(['pengasuhDanton', 'pengasuhDanki', 'pengasuhDanmen', 'peleton'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Peleton assignment statistics
        $tugasStats = [
            'total' => TugasPeleton::count(),
            'active' => TugasPeleton::active()->count(),
            'inactive' => TugasPeleton::inactive()->count(),
            'by_week' => TugasPeleton::groupByWeek()->get(),
        ];

        // Recent system activities
        $activities = TugasPeleton::select('created_at', 'minggu_ke', 'ton_ki_yon')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('superadmin.dashboard', compact(
            'userStats',
            'siswaStats',
            'pengasuhStats',
            'recentTugas',
            'tugasStats',
            'activities'
        ));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}