<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\DonationWallet;
use App\Models\Peserta;
use App\Models\Unit;
use App\Models\UnitWallet;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donasis = Donasi::with('unit')->latest()->get();
        return view('donasi.index', compact('donasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::with('wallet')->get();
        $pesertas = Peserta::orderBy('nama')->get();
        return view('donasi.create', compact('units', 'pesertas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:pesertas,id',
            'unit_id' => 'required|exists:units,id',
            'jumlah_donasi' => 'required|numeric|min:1',
            'keterangan' => 'nullable',
        ]);

        // Cek saldo wallet unit
        $wallet = UnitWallet::where('unit_id', $request->unit_id)->first();

        if (!$wallet || $wallet->balance < $request->jumlah_donasi) {
            return redirect()->back()->withInput()->with('error', 'Saldo wallet unit tidak mencukupi untuk jumlah donasi ini.');
        }

        $donasi = new Donasi();
        $donasi->peserta_id = $request->peserta_id;
        $donasi->unit_id = $request->unit_id;
        $donasi->jumlah_donasi = $request->jumlah_donasi;
        
        // Menggunakan tanggal saat ini
        $donasi->tanggal = Carbon::now();

        $donasi->keterangan = $request->keterangan;
        $donasi->status = 'menunggu bukti';
        $donasi->bukti_tf = null;
        $donasi->save();

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil disimpan.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_tf' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $donasi = Donasi::findOrFail($id);

        // Simpan file ke storage
        if ($request->hasFile('bukti_tf')) {
            $path = $request->file('bukti_tf')->store('bukti_tf', 'public');

            $donasi->bukti_tf = $path;
            $donasi->status = 'menunggu approval';
            $donasi->save();
        }

        return redirect()->route('donasi.index')->with('success', 'Bukti transfer berhasil diupload.');
    }

    public function approve($id)
    {
        $donasi = Donasi::findOrFail($id);

        if ($donasi->status !== 'menunggu approval') {
            return back()->with('error', 'Donasi tidak valid untuk disetujui.');
        }

        // Cek wallet unit
        $walletUnit = UnitWallet::where('unit_id', $donasi->unit_id)->first();
        if (!$walletUnit || $walletUnit->balance < $donasi->jumlah_donasi) {
            return back()->with('error', 'Saldo wallet unit tidak mencukupi.');
        }

        // Kurangi saldo unit
        $walletUnit->balance -= $donasi->jumlah_donasi;
        $walletUnit->save();

        // Tambah ke wallet donasi global
        $walletDonasi = DonationWallet::firstOrCreate([], ['saldo' => 0]);
        $walletDonasi->balance += $donasi->jumlah_donasi;
        $walletDonasi->save();

        // Update status donasi
        $donasi->status = 'disetujui';
        $donasi->save();

        return back()->with('success', 'Donasi disetujui. Saldo telah diperbarui.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Donasi $donasi)
    {
        return view('donasi.show', compact('donasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donasi $donasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donasi $donasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donasi $donasi)
    {
        //
    }
}
