<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Unit;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donasi = Donasi::with('unit')->latest()->get();
        return view('donasi.index', compact('donasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penabung = Unit::all();
        return view('donasi.create', compact('penabung'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'penabung_id' => 'required|exists:penabungs,id',
            'nama_peserta' => 'required|string',
            'jumlah_donasi' => 'required|numeric|min:1',
            'jumlah_penerima' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        Donasi::create($request->all());

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donasi $donasi)
    {
        //
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
