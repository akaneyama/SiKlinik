<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Polis;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polis = Polis::latest()->paginate(10);
        return view('polis.index',compact('polis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('polis.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_poli'=>['required','string','max:255'],
        ]);
        Polis::created([
            'nama_poli' => $request -> nama_poli,
        ]);
        return redirect()->route('polis.index')->with('sucess','Poli Berhasil Ditambahkan!.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Polis $polis)
    // {
    
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Polis $polis)
    {
        return view('polis.edit',compact('polis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Polis $polis)
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
