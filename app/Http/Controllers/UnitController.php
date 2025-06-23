<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penabung = Unit::all();
        return view('penabung.index', compact('penabung'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penabung.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
            'pic_name' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        Unit::create([
            'unit_name' => $request->unit_name,
            'pic_name' => $request->pic_name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('penabung.index')->with('success', 'Data unit berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $penabung)
    {
        return view('penabung.show', compact('penabung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $penabung)
    {
        return view('penabung.edit', compact('penabung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $penabung)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
            'pic_name' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $penabung->update($request->all());

        return redirect()->route('penabung.index')->with('success', 'Data unit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $penabung)
    {
        $penabung->delete();
        return back()->with('success', 'Data unit berhasil dihapus.');
    }
}
