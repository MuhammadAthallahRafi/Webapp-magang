<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        if (Pelamar::where('user_id', auth()->id())->exists()) {
        return redirect()->back()->with('error', 'Kamu sudah pernah mendaftar.');
    }
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kelamin'  => 'required|in:L,P', // ✅ validasi enum
            'nik'      => 'required|string|max:50',
            'kampus'   => 'required|string|max:255',
            'jurusan'  => 'required|string|max:255',
            'no_telp'  => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'alamat'   => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'cv'       => 'required|mimes:pdf|max:2048',
            'transkrip' => 'required|mimes:pdf|max:2048',
            'surat'    => 'required|mimes:pdf|max:2048',
        ]);

        // Simpan file CV
        $cvPath        = $request->file('cv')->store('cv', 'public');
        $transkripPath = $request->file('transkrip')->store('transkrip', 'public');
        $suratPath     = $request->file('surat')->store('surat', 'public');
        $user = auth()->user();

        // Simpan data (nanti bisa dimasukkan ke database model Pelamar)
        // Contoh sementara hanya simpan ke session untuk testing
       // Simpan ke database
        Pelamar::create([
            'user_id' => auth()->id(),
            'nama'    => $request->nama,
            'kelamin' => $request->kelamin, // ✅ disimpan di sini
            'nik'     => $request->nik,
            'kampus'  => $request->kampus,
            'jurusan' => $request->jurusan,
            'no_telp' => $request->no_telp,
            'email'   => $request->email,
            'alamat'  => $request->alamat,
            'tanggal_mulai'  => $request->tanggal_mulai,
            'tanggal_selesai'=> $request->tanggal_selesai,
            'cv'        => $cvPath,
            'transkrip' => $transkripPath,
            'surat'     => $suratPath,
            'status'    =>'pending',

            
        ]);
        
        $user = auth()->user();
        $user->status = 'on';
        $user->save();

        
        
        return redirect()->route('form.terimakasih');
    }

    
    public function terimaKasih()
    {
        $pelamar = Pelamar::where('user_id', auth()->id())->first();
        return view('pelamar.terima-kasih', compact('pelamar'));
    }

    public function showPenolakan($id)
    {
        $user = \App\Models\User::with('pelamar')->findOrFail($id);

        $alasan = $user->pelamar->alasan_penolakan ?? 'Tidak ada alasan diberikan';

        return view('pelamar.penolakan', [
        'alasan' => $alasan,
        'id' => $id, // ✅ dikirimkan
    ]);

    }

   public function showPerbaikan($id)
{
    $user = \App\Models\User::with('pelamar')->findOrFail($id);
    $pelamar = $user->pelamar;
    $alasan = $pelamar->alasan_perbaikan ?? 'Tidak ada alasan diberikan';

    return view('pelamar.perbaikan', [
        'alasan'  => $alasan,
        'id'=> $id,
        'user' => $user,
        'pelamar' => $pelamar, // ✅ dikirimkan
    ]);
}


    public function edit($id)
    {
         $pelamar = Pelamar::findOrFail($id);
        return view('pelamar.edit-formulir', compact('pelamar'));
    }

    public function update(Request $request, $id)
{
    $pelamar = Pelamar::findOrFail($id);
    $request->validate([
        'nama'      => 'required|string|max:255',
        'kelamin'  => 'required|in:L,P',
        'nik'       => 'required|string|max:50'.$pelamar->id,
        'kampus'    => 'required|string|max:255',
        'jurusan'   => 'required|string|max:255',
        'no_telp'   => 'required|string|max:20',
        'email'     => 'required|email',
        'alamat'    => 'required|string',
        'cv'        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'transkrip' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'surat'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'status'    => 'pending',
    ]);

    $data = $request->except(['cv','transkrip','surat']);

    if ($request->hasFile('cv')) {
        $data['cv'] = $request->file('cv')->store('cv', 'public');
    }

    if ($request->hasFile('transkrip')) {
        $data['transkrip'] = $request->file('transkrip')->store('transkrip', 'public');
    }

    if ($request->hasFile('surat')) {
        $data['surat'] = $request->file('surat')->store('surat', 'public');
    }

    $pelamar->update($data);

    return redirect()->route('form.terimakasih')->with('success', 'Formulir berhasil diperbarui.');
}



}
