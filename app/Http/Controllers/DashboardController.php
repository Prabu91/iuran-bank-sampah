<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Setoran;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSetoran = Setoran::sum('nominal');
        $totalDonasi = Donasi::sum('jumlah_donasi');
        $jumlahPenabung = Unit::count();


        // Ambil total per bulan (untuk grafik)
        $grafikSetoran = Setoran::selectRaw('MONTH(tanggal) as bulan, SUM(nominal) as total')
            ->groupBy('bulan')->orderBy('bulan')->get();

        return view('dashboard', compact('totalSetoran', 'totalDonasi', 'grafikSetoran', 'jumlahPenabung'));
    }
}
