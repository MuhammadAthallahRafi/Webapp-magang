<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{

    public function center($id = null)
{
    // ambil user login
    $user = auth()->user();

    // cari pelamar berdasarkan user_id (bukan id pelamar)
    $pelamar = \App\Models\Pelamar::with('user')
        ->where('user_id', $user->id)
        ->first();

    // jika belum isi form
    if (!$pelamar) {
        return redirect()->route('form.pendaftaran')
            ->with('info', 'Silakan isi form pendaftaran terlebih dahulu.');
    }

    // ambil alasan jika ada
    $alasan_penolakan = $pelamar->alasan_penolakan ?? null;
    $alasan_perbaikan = $pelamar->alasan_perbaikan ?? null;

    // kirim semua data ke view center
    return view('pelamar.center', [
        'user'              => $user,
        'pelamar'           => $pelamar,
        'alasan_penolakan'  => $alasan_penolakan,
        'alasan_perbaikan'  => $alasan_perbaikan,
    ]);
}




    public function store(Request $request)
    {
        if (Pelamar::where('user_id', auth()->id())->exists()) {
        return redirect()->back()->with('error', 'Kamu sudah pernah mendaftar.');
    }
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kelamin'  => 'required|in:L,P', // ✅ validasi enum
            'nik'      => 'required|digits:16|numeric|unique:pelamars,nik',
            'kampus'   => 'required|string|max:255',
            'jurusan'  => 'required|string|max:255',
            'no_telp'  => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'alamat'   => 'required|string',
            'tanggal_mulai'     => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'cv'       => 'required|mimes:pdf|max:2048',
            'transkrip' => 'required|mimes:pdf|max:2048',
            'surat'    => 'required|mimes:pdf|max:2048',]
            ,[
            'nik.unique' => 'NIK sudah terdaftar. Gunakan NIK lain.', // ✅ PESAN CUSTOM
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'cv.required' => 'File CV wajib diupload.',
            'cv.mimes' => 'File CV harus format PDF.',
            'cv.max' => 'File CV maksimal 2MB.',
            'transkrip.required' => 'File transkrip wajib diupload.',
            'transkrip.mimes' => 'File transkrip harus format PDF.',
            'transkrip.max' => 'File transkrip maksimal 2MB.',
            'surat.required' => 'File surat pengantar wajib diupload.',
            'surat.mimes' => 'File surat pengantar harus format PDF.',
            'surat.max' => 'File surat pengantar maksimal 2MB.',
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

        
        
        return redirect()->route('pelamar.center');
    }

    
    public function terimaKasih()
    {
        $pelamar = Pelamar::where('user_id', auth()->id())->first();
        return view('pelamar.center', compact('pelamar'));
    }

  public function showPenolakan($id)
{
    // Ambil pelamar berdasarkan id pelamar (sesuai kebutuhan kamu)
    $pelamar = \App\Models\Pelamar::with('user')->findOrFail($id);

    // ambil user lewat relasi
    $user = $pelamar->user;

    // ambil alasan dari model pelamar (fallback teks jika kosong)
    $alasan = $pelamar->alasan_penolakan ?? 'Tidak ada alasan diberikan';

    // kirim semua variabel yang mungkin dibutuhkan view
    return view('pelamar.penolakan', [
        'alasan'  => $alasan,
        'id'      => $id,
        'user'    => $user,
        'pelamar' => $pelamar,
    ]);
}


   public function showPerbaikan($id)
{
    // Ambil pelamar langsung berdasarkan id pelamar
    $pelamar = \App\Models\Pelamar::with('user')->findOrFail($id);

    $alasan = $pelamar->alasan_perbaikan ?? 'Tidak ada alasan diberikan';
    $user = $pelamar->user; // ambil data user-nya dari relasi

    return view('pelamar.perbaikan', [
        'alasan'  => $alasan,
        'id'      => $id,
        'user'    => $user,
        'pelamar' => $pelamar,
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
        'kelamin'   => 'required|in:L,P',
         'nik'      => 'required|digits:16|numeric|unique:pelamars,nik,' . $pelamar->id,
        'kampus'    => 'required|string|max:255',
        'jurusan'   => 'required|string|max:255',
        'no_telp'   => 'required|string|max:20',
        'email'     => 'required|email',
        'alamat'    => 'required|string',
        'tanggal_mulai'     => 'required|date|after_or_equal:today',
        'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
        'cv'        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'transkrip' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'surat'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]
        ,[
            'nik.unique' => 'NIK sudah terdaftar. Gunakan NIK lain.', // ✅ PESAN CUSTOM
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'cv.required' => 'File CV wajib diupload.',
            'cv.mimes' => 'File CV harus format PDF.',
            'cv.max' => 'File CV maksimal 2MB.',
            'transkrip.required' => 'File transkrip wajib diupload.',
            'transkrip.mimes' => 'File transkrip harus format PDF.',
            'transkrip.max' => 'File transkrip maksimal 2MB.',
            'surat.required' => 'File surat pengantar wajib diupload.',
            'surat.mimes' => 'File surat pengantar harus format PDF.',
            'surat.max' => 'File surat pengantar maksimal 2MB.',
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

    if ($pelamar->status === 'perbaikan'){
        $pelamar->update([
            'status'           => 'telahdiperbaiki',
        ]);
        }
    $pelamar->update($data);
    
    return redirect()->route('pelamar.data-diri')->with('success', 'Formulir berhasil diperbarui.');
}
public function dataDiri()
{
    $user = auth()->user();

    // Pastikan hanya role pelamar yang bisa akses
    if ($user->role !== 'pelamar') {
        abort(403, 'Akses ditolak.');
    }

    $pelamar = $user->pelamar; // Relasi user -> pelamar

    if (!$pelamar) {
        return redirect()->route('form-pendaftaran')
            ->with('info', 'Kamu belum mengisi form pendaftaran.');
    }

    return view('pelamar.data-diri', compact('pelamar'));
}



}
