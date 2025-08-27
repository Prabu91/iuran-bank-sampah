<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Unit;
use App\Models\UnitWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SetoranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setoran = Setoran::with('unit')->latest()->get();
        return view('setoran.index', compact('setoran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        return view('setoran.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'unit_id'       => 'required|exists:units,id',
            'nama_penyetor' => 'required|string',
            'tanggal'       => 'required|date',
            'nominal'       => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string',
            'bukti_setor' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('bukti_setor');

        if ($request->hasFile('bukti_setor')) {
            $path = $request->file('bukti_setor')->store('bukti-setor', 'public');
            $data['bukti_setor_path'] = str_replace('public/', '', $path);
        }

        Setoran::create($data);

        // Lanjutkan dengan logika update saldo
        $wallet = UnitWallet::firstOrCreate(
            ['unit_id' => $request->unit_id],
            ['balance' => 0]
        );

        $wallet->balance += $request->nominal;
        $wallet->save();

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setoran $setoran)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setoran $setoran)
    {
        $units = Unit::all();
        return view('setoran.edit', compact('setoran', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setoran $setoran)
    {
        $old_nominal = $setoran->nominal;

        $request->validate([
            'unit_id'       => 'required|exists:units,id',
            'nama_penyetor' => 'required|string',
            'tanggal'       => 'required|date',
            'nominal'       => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string',
            // 'bukti_setor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bukti_setor' => 'required|max:2048',
        ]);

        $data = $request->except('bukti_setor');

        if ($request->hasFile('bukti_setor')) {
            // Hapus file lama jika ada
            if ($setoran->bukti_setor_path) {
                Storage::delete('public/' . $setoran->bukti_setor_path);
            }
            $path = $request->file('bukti_setor')->store('public/bukti-setor');
            $data['bukti_setor_path'] = str_replace('public/', '', $path);
        }

        $setoran->update($data);

        if ($request->nominal != $old_nominal) {
            $wallet = UnitWallet::firstOrCreate(
                ['unit_id' => $setoran->unit_id],
                ['balance' => 0]
            );
            $nominal_diff = $request->nominal - $old_nominal;
            $wallet->balance += $nominal_diff;
            $wallet->save();
        }

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setoran $setoran)
    {
        // Cek apakah setoran memiliki bukti setor
        if ($setoran->bukti_setor_path) {
            // Hapus file bukti setor dari penyimpanan
            Storage::disk('public')->delete($setoran->bukti_setor_path);
        }

        // Ambil nominal setoran yang akan dihapus
        $nominal_setoran = $setoran->nominal;

        // Ambil dompet unit terkait
        $wallet = $setoran->unit->wallet;

        // Pastikan dompet ada sebelum mengupdate saldo
        if ($wallet) {
            // Kurangi saldo dompet dengan nominal setoran
            $wallet->balance -= $nominal_setoran;
            $wallet->save();
        }

        // Hapus data setoran dari database
        $setoran->delete();

        return back()->with('success', 'Data setoran berhasil dihapus dan saldo telah disesuaikan.');
    }
}
