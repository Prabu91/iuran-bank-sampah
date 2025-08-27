<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\DonationWallet;
use App\Models\Setoran;
use App\Models\Unit;
use App\Models\UnitWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data filter dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        // --- Data Total Kumulatif (Real-time dari Wallets) ---
        // Catatan: Ini akan menampilkan saldo terakhir dan tidak terpengaruh filter
        // unless you adjust the logic below
        $totalSaldoUnit = UnitWallet::sum('balance');
        $totalSaldoDonasi = DonationWallet::sum('balance');
        $jumlahPenabung = Unit::count();
        
        // --- Data Total Dinamis (Bisa Difilter) ---
        // Total uang terkumpul dari setoran berdasarkan filter
        $totalSetoran = Setoran::query();
        if ($bulan) {
            $totalSetoran->whereMonth('created_at', $bulan);
        }
        $totalSetoran->whereYear('created_at', $tahun);
        $totalSetoran = $totalSetoran->sum('nominal');

        // Total donasi berdasarkan filter
        $totalDonasi = Donasi::query()
            ->where('status', 'disetujui');
        if ($bulan) {
            $totalDonasi->whereMonth('created_at', $bulan);
        }
        $totalDonasi->whereYear('created_at', $tahun);
        $totalDonasi = $totalDonasi->sum('jumlah_donasi');
        
        // --- Data untuk Pie Chart (Historis, Bisa Difilter) ---
        
        // Data untuk Pie Chart Donasi per Unit
        $donasiPerUnitQuery = Donasi::query()
            ->select('units.unit_name', DB::raw('SUM(donasis.jumlah_donasi) as total_donasi'))
            ->where('donasis.status', 'disetujui')
            ->join('units', 'donasis.unit_id', '=', 'units.id');

        if ($bulan) {
            $donasiPerUnitQuery->whereMonth('donasis.created_at', $bulan);
        }
        $donasiPerUnitQuery->whereYear('donasis.created_at', $tahun);

        $donasiPerUnit = $donasiPerUnitQuery
            ->groupBy('units.unit_name')
            ->orderBy('total_donasi', 'desc')
            ->get();
        
        // Data untuk Pie Chart Setoran (Tabungan) per Unit
        $setoranPerUnitQuery = Setoran::query()
            ->select('units.unit_name', DB::raw('SUM(setorans.nominal) as total_setoran'))
            ->join('units', 'setorans.unit_id', '=', 'units.id');

        if ($bulan) {
            $setoranPerUnitQuery->whereMonth('setorans.created_at', $bulan);
        }
        $setoranPerUnitQuery->whereYear('setorans.created_at', $tahun);

        $setoranPerUnit = $setoranPerUnitQuery
            ->groupBy('units.unit_name')
            ->orderBy('total_setoran', 'desc')
            ->get();
            
        // Ambil semua unit untuk memastikan pie chart memiliki semua label, 
        // bahkan jika tidak ada setoran atau donasi
        $allUnits = Unit::pluck('unit_name')->toArray();

        // Menggabungkan data donasi per unit dengan semua unit
        $donasiChartData = $donasiPerUnit->mapWithKeys(function ($item) {
            return [$item['unit_name'] => (int) $item['total_donasi']];
        })->toArray();
        $donasiChartData = array_merge(array_fill_keys($allUnits, 0), $donasiChartData);

        // Menggabungkan data setoran per unit dengan semua unit
        $setoranChartData = $setoranPerUnit->mapWithKeys(function ($item) {
            return [$item['unit_name'] => (int) $item['total_setoran']];
        })->toArray();
        $setoranChartData = array_merge(array_fill_keys($allUnits, 0), $setoranChartData);

        return view('dashboard', compact(
            'totalSetoran', 
            'totalDonasi', 
            'jumlahPenabung', 
            'donasiChartData',
            'setoranChartData',
            'donasiPerUnit',
            'setoranPerUnit'
        ));
    }
}
