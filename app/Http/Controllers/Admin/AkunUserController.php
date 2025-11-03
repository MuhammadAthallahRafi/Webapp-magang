<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;

class AkunUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.akun-user', compact('users'));
    }

    public function createUnitkerja()
    {
        return view('admin.create-admin-unitkerja');
    }

    public function storeUnitkerja(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'divisi' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin-unitkerja',
            'divisi' => $request->divisi,
        ]);

        return redirect()->route('admin.akun-user.index')->with('success', 'Admin Unit Kerja berhasil dibuat.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-akun-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

       $request->validate([
    'name'   => 'required|string|max:255',
    'email'  => "required|email|unique:users,email,{$id}",
    'role'   => 'required|string',   // kalau ada pilihan role
    'status' => 'required|string',   // kalau ada status aktif/off
        ]);

        $user->update($request->only(['name', 'email', 'role', 'status']));


        return redirect()->route('admin.akun-user.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }

    public function toggleStatus($id)
{
    $user = User::findOrFail($id);

    // Toggle status user
    $user->status = $user->status === 'off' ? 'on' : 'off';
    $user->save();

    // Jika user dinonaktifkan, ubah juga status peserta menjadi 'mundur'
    if ($user->status === 'off') {
        $peserta = \App\Models\Peserta::where('user_id', $user->id)->first();
        if ($peserta) {
            $peserta->status = 'mundur';
            $peserta->save();
        }
    }

    $pesan = $user->status === 'off'
        ? 'Akun berhasil dinonaktifkan dan status peserta diubah menjadi mundur.'
        : 'Akun berhasil diaktifkan kembali.';

    return back()->with('success', $pesan);
}


}
