<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // <--- PERBAIKAN 2: Import Facade Auth

class UserController extends Controller
{
    // Tampilkan Daftar User
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'role' => 'required|in:admin,manager',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Hapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah hapus diri sendiri
        // PERBAIKAN 3: Menggunakan Auth::id() menggantikan auth()->id()
        if (Auth::id() == $id) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun sendiri saat sedang login.']);
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
