<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
            'pengaduan_id' => 'required|exists:pengaduans,id',
        ]);

        Tanggapan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'isi_tanggapan' => $request->isi_tanggapan,
            'petugas_id' => $request->user()->id,
        ]);

        Pengaduan::where('id', $request->pengaduan_id)->update([
            'status' => 'Diproses',
        ]);
        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
        ]);

        $tanggapan = Tanggapan::findOrFail($id);
        $tanggapan->isi_tanggapan = $request->isi_tanggapan;
        $tanggapan->save();

        return redirect()->back()->with('success', 'Tanggapan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanggapan $tanggapan)
    {
        //
    }
}
