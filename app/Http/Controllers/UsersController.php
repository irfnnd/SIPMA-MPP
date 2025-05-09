<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request , User $user)
    {
        $this->authorize('viewAny', User::class);
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $user = $user ?? new User();

        $penggunas = User::when($search, function ($query, $search) {
            return $query->where('nama_unit', 'like', "%{$search}%");
        })->paginate($perPage)->appends($request->query());

        return view('admin.data-users.index', compact('penggunas', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('viewAny', User::class);
        $user = new User(); // kosong untuk form
        return view('admin.data-users.form', compact('user'));
    }

    public function store(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,petugas,masyarakat',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('data-pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $data_pengguna)
    {
        $this->authorize('viewAny', User::class);
        return view('admin.data-users.form', [
            'user' => $data_pengguna // ubah namanya jadi $user di view
        ]);
    }


    public function update(Request $request, User $data_pengguna)
    {
        $this->authorize('viewAny', User::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|' . Rule::unique('users')->ignore($data_pengguna->id),
            'role' => 'required|in:admin,petugas,masyarakat',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = $request->only('name', 'email', 'role', 'phone');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $data_pengguna->id)->update($data);

        return redirect()->route('data-pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $data_pengguna)
    {
        $this->authorize('viewAny', User::class);
        $data_pengguna->delete();
        return redirect()->route('data-pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
