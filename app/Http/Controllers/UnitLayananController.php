<?php
namespace App\Http\Controllers;

use App\Models\UnitLayanan;
use Illuminate\Http\Request;

class UnitLayananController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $perPage = $request->perPage ?? 10;

    $units = UnitLayanan::when($search, function ($query, $search) {
        return $query->where('nama_unit', 'like', "%{$search}%");
    })->paginate($perPage)->appends($request->query());

    return view('admin.unit-layanan.index', compact('units'));
}


    public function create()
    {
        return view('admin.unit-layanan.form', ['unit' => new UnitLayanan()]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_unit' => 'required']);

        UnitLayanan::create($request->all());

        return redirect()->route('unit.index')->with('success', 'Unit berhasil ditambahkan');
    }


    public function edit(UnitLayanan $unit)
    {
        return view('admin.unit-layanan.form', compact('unit'));
    }

    public function update(Request $request, UnitLayanan $unit)
    {
        $request->validate(['nama_unit' => 'required']);
        $unit->update($request->all());
        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui');
    }

    public function destroy(UnitLayanan $unit)
    {
        $unit->delete();
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus');
    }
}
