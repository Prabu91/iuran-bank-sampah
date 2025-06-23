<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Unit;
use Illuminate\Http\Request;

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
        $penabung = Unit::all();
        return view('setoran.create', compact('penabung'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'nama_penyetor' => 'required|string',
            'type' => 'required|string',
            'sampah' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric|min:0.1',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string',
        ]);


        Setoran::create($request->all());

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setoran $setoran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setoran $setoran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setoran $setoran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setoran $setoran)
    {
        //
    }
}
