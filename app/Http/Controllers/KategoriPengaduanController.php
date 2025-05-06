<?php
namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriPengaduanController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $perPage = $request->perPage ?? 10;

    $kategoris = KategoriPengaduan::when($search, function ($query, $search) {
        return $query->where('nama_kategori', 'like', "%{$search}%");
    })->paginate($perPage)->appends($request->query());

    return view('admin.kategori.index', compact('kategoris'));
}


    public function create()
    {
        return view('admin.kategori.form', ['kategori' => new KategoriPengaduan()]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);

        KategoriPengaduan::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }


    public function edit(KategoriPengaduan $kategori)
    {
        return view('admin.kategori.form', compact('kategori'));
    }

    public function update(Request $request, KategoriPengaduan $kategori)
    {
        $request->validate(['nama_kategori' => 'required']);
        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(KategoriPengaduan $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
