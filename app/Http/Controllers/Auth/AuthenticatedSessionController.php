<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // Autentikasi user
    $request->authenticate();
    $request->session()->regenerate();  

    $user = auth()->user();

    // Redirect berdasarkan role
   if ($user->role === 'admin') {
    return redirect()->to('/dashboard/admin');

    } elseif ($user->role === 'admin-unitkerja') {
        return redirect()->to('/dashboard/admin-unitkerja');

    } elseif ($user->role === 'magang') {
        if ($user->peserta && $user->peserta->status === 'mundur') {
            return redirect()->route('mundur.show', $user->peserta->id);
        }
        if ($user->peserta && $user->peserta->status === 'lulus') {
            return redirect()->route('lulus.show', $user->peserta->id);
        }
        return redirect()->to('/dashboard/magang');

    } elseif ($user->role === 'pelamar') {
        if ($user->pelamar && $user->pelamar->status === 'ditolak') {
            return redirect()->route('penolakan.show', $user->pelamar->id);
        }

        if ($user->pelamar && $user->pelamar->status === 'perbaikan') {
            return redirect()->route('perbaikan.show', $user->pelamar->id);
        }

        if (!$user->pelamar) {
            // Belum isi form → diarahkan ke form pendaftaran
            return redirect()->to('/form-pendaftaran');
        }

        // Sudah isi form normal → ke dashboard pelamar
        return redirect()->to('/');
    }




    // Fallback default
    return redirect()->to('/');
}





    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
