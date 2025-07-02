<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesertas = Peserta::latest()->get();
        return view('peserta.index', compact('pesertas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('peserta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik'            => 'required|string|unique:pesertas',
            'nama'           => 'required|string',
            'noka'           => 'required|string|unique:pesertas',
            'no_hp'          => 'nullable|string',
            'alamat'         => 'nullable|string',
            'kecamatan'      => 'nullable|string',
            'bln_menunggak'  => 'nullable|integer|min:0',
            'total_tagihan'  => 'nullable|numeric|min:0',
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peserta $peserta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peserta $peserta)
    {
        return view('peserta.edit', compact('peserta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'nik'            => 'required|string|unique:pesertas,nik,' . $peserta->id,
            'nama'           => 'required|string',
            'noka'           => 'required|string|unique:pesertas,noka,' . $peserta->id,
            'no_hp'          => 'nullable|string',
            'alamat'         => 'nullable|string',
            'kecamatan'      => 'nullable|string',
            'bln_menunggak'  => 'nullable|integer|min:0',
            'total_tagihan'  => 'nullable|numeric|min:0',
        ]);

        $peserta->update($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peserta $peserta)
    {
        $peserta->delete();
        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
