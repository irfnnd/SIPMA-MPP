<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use App\Models\UnitLayanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $masyarakatCount = User::where('role', 'masyarakat')->count();
        $petugasCount = User::where('role', 'petugas')->count();
        $adminCount = User::where('role', 'admin')->count();
        $unitCount = UnitLayanan::count();
        $kategoriCount = KategoriPengaduan::count();
        $pengaduanCount = Pengaduan::count();
        $pendingPengaduan = Pengaduan::where('status', 'Menunggu')->count();
        $processedPengaduan = Pengaduan::where('status', 'Diproses')->count();
        $completedPengaduan = Pengaduan::where('status', 'Selesai')->count();
        $pengaduans = Pengaduan::latest()->paginate(5);
        $monthlyData = Pengaduan::query()

        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupByRaw('MONTH(created_at)')
        ->pluck('total', 'month')
        ->toArray();

    // Lengkapi data bulan yang kosong
    $chartLabels = [];
    $chartData = [];



    for ($i = 1; $i <= 12; $i++) {
        $chartLabels[] = Carbon::create()->month($i)->format('F'); // Nama bulan
        $chartData[] = $monthlyData[$i] ?? 0;
    }
    

        return view('admin.dashboard', compact(
            'userCount',
            'masyarakatCount',
            'petugasCount',
            'unitCount',
            'kategoriCount',
            'pengaduanCount',
            'pendingPengaduan',
            'processedPengaduan',
            'completedPengaduan',
            'pengaduans',
            'chartLabels',
            'chartData',
            'adminCount'
        ));
    }
}
