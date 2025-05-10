<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;

        $pengaduans = Pengaduan::with('tanggapan', 'petugas')->when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%{$search}%");
        })->paginate($perPage)->appends($request->query());

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function index2(Request $request)
    {
        $user = $request->user();
        $pengaduans = Pengaduan::with('tanggapan.petugas', 'petugas')->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pengadu.lihat-pengaduan', compact('pengaduans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = \App\Models\KategoriPengaduan::all(); // sesuaikan dengan model Anda
        $unit = \App\Models\UnitLayanan::all();         // sesuaikan juga

        return view('pengadu.formpengaduan', compact('kategori', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'kategori_id' => 'required|exists:kategori_pengaduans,id',
            'unit_id' => 'required|exists:unit_layanans,id',
            'lokasi' => 'nullable|string|max:255',
            'lampiran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')->store('pengaduan/lampiran', 'public');
        }

        Pengaduan::create([
            'user_id' => $request->user()->id, // Laravel 12 style
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'kategori_id' => $request->kategori_id,
            'unit_id' => $request->unit_id,
            'lokasi' => $request->lokasi,
            'lampiran' => $lampiran,
            'status' => 'Menunggu', // default status
        ]);

        return redirect()->route('pengaduan.create')->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $data_pengaduan)
    {
        Pengaduan::where('id', $data_pengaduan)->update([
            'status' => 'Selesai',
        ]);

        return redirect()->route('data-pengaduan.index')->with('success', 'Status pengaduan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
