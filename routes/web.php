<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pelamar\PendaftaranController;//punya role pelamar

use App\Http\Controllers\Admin\AdminController;//punya admin
use App\Http\Controllers\Admin\PelamarController;//punya admin
use App\Http\Controllers\Admin\PelamarDitolakController;//punya admin
use App\Http\Controllers\Admin\PesertaController;//punya admin
use App\Http\Controllers\Admin\AkunUserController;//punya admin
use App\Http\controllers\Admin\PesertaLulusController;//punya admin
use App\Http\Controllers\Admin\PermohonanPeriodeController as AdminPermohonanPeriodeController;//punya admin

use App\Http\Controllers\Adminunitkerja\PesertaMagangUnitKerjaController;//punya admin unitkerja
use App\Http\Controllers\Adminunitkerja\PesertaLulusController as PesertaunitLulusController;//punya admin unitkerja
use App\Http\Controllers\Adminunitkerja\PermohonanPeriodeController as AdminunitkerjaPermohonanPeriodeController;//punya admin unitkerja

use App\Http\Controllers\Peserta\PesertaMagangController;//punya peserta magang
use App\Http\Controllers\Peserta\PermohonanPeriodeController;//punya peserta magang
// Landing Page
Route::get('/', function () {
    return view('landing');
});


Route::get('/redirect-role', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/dashboard/admin');

    } elseif ($user->role === 'admin-unitkerja') {
        return redirect('/dashboard/admin-unitkerja');

    } elseif ($user->role === 'magang') {
        if ($user->peserta && $user->peserta->status === 'mundur') {
            return redirect()->route('mundur.show', $user->peserta->id);
        }
        if ($user->peserta && $user->peserta->status === 'lulus') {
            return redirect()->route('lulus.show', $user->peserta->id);
        }
        return redirect('/dashboard/magang');

    } elseif ($user->role === 'pelamar') {
        if ($user->pelamar && $user->pelamar->status === 'ditolak') {
            return redirect()->route('penolakan.show', $user->pelamar->id);
        } elseif ($user->pelamar && $user->pelamar->status === 'perbaikan') {
            return redirect()->route('perbaikan.show', $user->pelamar->id);
        }
        return redirect('/form-pendaftaran');
    }

    // fallback
    return redirect('/');
});





// Route untuk logout
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// ================== Admin unitkerja ================== //
    Route::middleware(['auth', 'role:admin-unitkerja'])->group(function () {
    
        // Dashboard
    Route::get('/dashboard/admin-unitkerja', function () {
        return view('admin-unitkerja.dashboard');
    })->name('dashboard.admin-unitkerja');

//========= Route Power peserta magang (Admin unit kerja) ============//
    //lihat seluruh peserta unit kerja
    Route::get('/admin-unitkerja/peserta-magang', [PesertaMagangUnitKerjaController::class, 'index'])
        ->name('admin-unitkerja.peserta-magang');
    //lihat data diri peserta unit kerja
    Route::get('/admin-unitkerja/peserta-magang/{id}/lihat', [PesertaMagangUnitKerjaController::class, 'show'])
        ->name('admin-unitkerja.peserta-magang.lihat');
    //lihat data periode peserta unit kerja
    Route::get('/admin-unitkerja/peserta-magang/{id}/periode', [PesertaMagangUnitKerjaController::class, 'periode'])
        ->name('admin-unitkerja.peserta-magang.periode');
    // update nilai langsung
    Route::post('/admin-unitkerja/peserta-magang/{id}/update-nilai', [PesertaMagangUnitKerjaController::class, 'updateNilai'])
        ->name('admin-unitkerja.peserta-magang.update-nilai');
    // update status langsung
    Route::post('/admin-unitkerja/peserta-magang/{id}/update-status', [PesertaMagangUnitKerjaController::class, 'updateStatus'])
        ->name('admin-unitkerja.peserta-magang.update-status');
    //lihat data absensi
    Route::get('/admin-unitkerja/peserta-magang/{id}/absensi', [PesertaMagangUnitKerjaController::class, 'absensi'])
        ->name('admin-unitkerja.peserta-magang.absensi');
    // update keterangan absensi langsung
    Route::post('/admin-unitkerja/absensi/{id}/update-keterangan', [PesertaMagangUnitKerjaController::class, 'updateKeterangan'])
        ->name('admin-unitkerja.absensi.update-keterangan');
    // tombol meluluskan dan mengisi nilai
    Route::post('/admin-unitkerja/peserta-magang/{id}/lulus', [PesertaMagangUnitKerjaController::class, 'lulus'])
        ->name('admin-unitkerja.peserta-magang.lulus');
    // tombol memundurkan peserta dari unit kerjanya
    Route::post('/admin-unitkerja/peserta-magang/{id}/mundur', [PesertaMagangUnitKerjaController::class, 'mundur'])
        ->name('admin-unitkerja.peserta-magang.mundur');

    Route::get('/admin-unitkerja/permohonan-periode', [AdminunitkerjaPermohonanPeriodeController::class, 'index'])
       ->name('admin-unitkerja.permohonan-periode');
    // Approve
    Route::post('/admin-unitkerja/permohonan/{id}/approve', [AdminunitkerjaPermohonanPeriodeController::class, 'approve'])
    ->name('admin-unitkerja.permohonan.approve');
    //Tolak
    Route::post('/admin-unitkerja/permohonan/{id}/reject', [AdminunitkerjaPermohonanPeriodeController::class, 'reject'])
    ->name('admin-unitkerja.permohonan.reject');

    //========= Route Power peserta magang lulus (Admin unit kerja) ============//
    //lihat seluruh peserta unit kerja lulus
    Route::get('/admin-unitkerja/peserta-lulus', [PesertaunitLulusController::class, 'index'])
        ->name('admin-unitkerja.peserta-lulus.index');
    // Cetak Sertifikat
    Route::get('/admin-unitkerja/peserta-lulus/{id}/sertifikat', [PesertaunitLulusController::class, 'cetakSertifikat'])
        ->name('admin-unitkerja.peserta-lulus.sertifikat');

});


// ================== Route Authenticated Admin================== //
Route::middleware(['auth', 'role:admin'])->group(function () {

    // ================== Admin ================== //
    // Masuk Dashboard Admin
   Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');
    //========= Route Power Pelamar (Admin) ============//
    // Halaman Admin melihat daftar pelamar
    Route::get('/admin/pelamar', [PelamarController::class, 'index'])
        ->name('admin.pelamar');
    // Halaman Admin melihat Detail Pelamar
    Route::get('/admin/pelamar/{id}', [PelamarController::class, 'show'])
        ->name('admin.pelamar.lihat');
    // Terima Pelamar
    Route::post('/admin/pelamar/{id}/terima', [PelamarController::class, 'terima'])
        ->name('admin.pelamar.terima');
    // Tolak Pelamar
    Route::post('/admin/pelamar/{id}/tolak', [PelamarController::class, 'tolak'])
        ->name('admin.pelamar.tolak');
    // mengambil data pelamar    
    Route::get('/admin/peserta-magang', [PelamarController::class, 'daftarMagang'])
        ->name('admin.peserta-magang');
    // route untuk perbaikan pelamar
    Route::post('/admin/pelamar/{id}/perbaikan', [PelamarController::class, 'perbaikan'])
    ->name('admin.pelamar.perbaikan');
    // Terima Peserta yang magang kembali (controller pinjaman)
    Route::post('/admin/pelamar/{id}/approve', [AdminPermohonanPeriodeController::class, 'approve'])
    ->name('admin.periode.approve');
    // Tolak Peserta yang magang kembali (controller pinjaman)
    Route::post('/admin/pelamar/{id}/reject', [AdminPermohonanPeriodeController::class, 'reject'])
    ->name('admin.periode.reject');
    

    //========= Route Power Pelamarditolak (Admin) ============//
    // Halaman Admin melihat daftar pelamar
    Route::get('/admin/pelamarditolak', [PelamarDitolakController::class, 'index'])
        ->name('admin.pelamarditolak');
    // Halaman Admin melihat Detail Pelamar
    Route::get('/admin/pelamarditolak/{id}', [PelamarDitolakController::class, 'show'])
        ->name('admin.pelamarditolak.lihat');
    // Terima Pelamar
    Route::post('/admin/pelamarditolak/{id}/terima', [PelamarDitolakController::class, 'terima'])
        ->name('admin.pelamarditolak.terima');
    // mengambil data pelamar    
    Route::get('/admin/peserta-magang', [PelamarDitolakController::class, 'daftarMagang'])
        ->name('admin.peserta-magang');
    // route untuk perbaikan pelamar
    Route::post('/admin/pelamarditolak/{id}/perbaikan', [PelamarDitolakController::class, 'perbaikan'])
    ->name('admin.pelamarditolak.perbaikan');
    

    //========= Route Power peserta magang (Admin) ============//
    // Halaman Admin melihat peserta magang
    Route::get('/admin/peserta-magang', [PesertaController::class, 'index'])
    ->name('admin.peserta-magang');
    // Halaman Admin melihat Detail peserta magang
    Route::get('/admin/peserta-magang/{id}', [PesertaController::class, 'show'])
        ->name('admin.peserta-magang.lihat');
   // Route Admin Untuk Update Divisi peserta
    Route::post('/admin/peserta-magang/{id}/update-divisi', [PesertaController::class, 'updateDivisi'])
    ->name('admin.peserta-magang.update-divisi');
    // Route Admin Untuk Update Nilai
    Route::post('/admin/peserta-magang/{id}/update-nilai', [PesertaController::class, 'updateNilai'])
    ->name('admin.peserta-magang.update-nilai');
    // Route Admin Untuk Update Status
    Route::post('/admin/peserta-magang/{id}/update-status', [PesertaController::class, 'updateStatus'])
    ->name('admin.peserta-magang.update-status');
    // Riwayat Absensi peserta Magang
    Route::get('/admin/peserta-magang/{id}/absensi', [PesertaController::class, 'absensi'])
        ->name('admin.peserta-magang.absensi');
    // Ambil data peserta dan semua periode magangnya
    Route::get('/admin/peserta-magang/{id}/periode', [PesertaController::class, 'periode'])
        ->name('admin.peserta-magang.periode');
    // Route Admin Untuk Update Keterangan
    Route::post('/admin/peserta-magang/{id}/update-keterangan', [PesertaController::class, 'updateKeterangan'])
    ->name('admin.peserta-magang.update-keterangan');
    // Route Admin Untuk meluluskan
    Route::post('/admin/peserta-magang/{id}/lulus', [PesertaController::class, 'lulus'])
    ->name('admin.peserta-magang.lulus');
    // Route Admin Untuk memundurkan
    Route::post('/admin/peserta-magang/{id}/mundur', [PesertaController::class, 'mundur'])
    ->name('admin.peserta-magang.mundur');


    //========= Route Power permohonan periode (Admin) ============//
    // Halaman Admin melihat permohonan periode
    Route::get('/admin/permohonan-periode', [AdminPermohonanPeriodeController::class, 'index'])
       ->name('admin.permohonan-periode');
    // Approve
    Route::post('/admin/permohonan/{id}/approve', [AdminPermohonanPeriodeController::class, 'approve'])
    ->name('admin.permohonan.approve');
    //Tolak
    Route::post('/admin/permohonan/{id}/reject', [AdminPermohonanPeriodeController::class, 'reject'])
    ->name('admin.permohonan.reject');




    //========= Route Power peserta lulus (Admin) ============//
    // Halaman Admin melihat  peserta lulus 
    Route::get('/admin/peserta-lulus', [\App\Http\Controllers\Admin\PesertaLulusController::class, 'index'])
        ->name('admin.peserta-lulus.index');
    // Cetak Sertifikat
    Route::get('/admin/peserta-lulus/{id}/sertifikat', [\App\Http\Controllers\Admin\PesertaLulusController::class, 'cetakSertifikat'])
        ->name('admin.peserta-lulus.sertifikat');



    });

    //========= Route Power akun user (Admin) ============//
    // Route Admin Untuk Update akun user
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('akun-user', AkunUserController::class)->except(['create', 'store', 'show']);
    // Route Admin Untuk bikin akun user admin unitkerja 
        Route::get('/akun-user/create-unitkerja', [AkunUserController::class, 'createUnitkerja'])->name('akun-user.create-unitkerja');
    Route::post('/akun-user/store-unitkerja', [AkunUserController::class, 'storeUnitkerja'])->name('akun-user.store-unitkerja');
    });

        


    



// ================== Route Authenticated peserta Magang ================== //
Route::middleware(['auth', 'role:magang'])->group(function () {
    
    // ===== Dashboard utama peserta magang =====
    Route::get('/dashboard/magang', [PesertaMagangController::class, 'dashboard'])
        ->name('dashboard.magang');

    // ===== Aksi absensi harian =====
    Route::post('/dashboard/magang/absensi', [PesertaMagangController::class, 'absensi'])
        ->name('dashboard.magang.absensi');

    // ===== Aksi absen pulang =====
    Route::post('/dashboard/magang/pulang', [PesertaMagangController::class, 'pulang'])
        ->name('dashboard.magang.pulang');

    // ===== Riwayat kehadiran magang =====
    Route::get('/magang/riwayat', [PesertaMagangController::class, 'riwayat'])
        ->name('magang.riwayat');

    // ===== Halaman data diri peserta magang =====
    Route::get('/magang/data-diri', [PesertaMagangController::class, 'dataDiri'])
        ->name('magang.data-diri');

    // ===== Detail permohonan mundur magang =====
    Route::get('/magang/mundur/{id}', [PesertaMagangController::class, 'show'])
        ->name('mundur.show');

    // ===== Detail kelulusan magang =====
    Route::get('/magang/lulus/{id}', [PesertaMagangController::class, 'show'])
        ->name('lulus.show');

    // ===== Tambah data pendidikan di halaman data diri =====
    Route::post('/magang/data-diri/tambahPendidikan/{id}', [PesertaMagangController::class, 'tambahPendidikan'])
        ->name('magang.data-diri.tambahPendidikan');   

    // ================== Permohonan Periode ================== //

    // ===== Permohonan percepatan periode magang =====
    Route::post('/magang/permohonan-periode/percepat', [PermohonanPeriodeController::class, 'permohonanPercepat'])
        ->name('magang.periode.percepat');

    // ===== Permohonan penambahan periode magang =====
    Route::post('/magang/permohonan-periode/tambah', [PermohonanPeriodeController::class, 'permohonanTambah'])
        ->name('magang.periode.tambah');
    
    // ===== Permohonan pengunduran diri magang =====
    Route::post('/magang/permohonan-periode/mundur', [PermohonanPeriodeController::class, 'permohonanMundur'])
        ->name('magang.periode.mundur');

    // ===== Permohonan magang kembali (setelah mundur) =====
    Route::post('/magang/permohonan-periode/permohonanmagangkembali', [PermohonanPeriodeController::class, 'permohonanMagangKembali'])
        ->name('magang.periode.permohonanmagangkembali');

    // ===== Cek status permohonan periode magang =====
    Route::get('/magang/status', [PermohonanPeriodeController::class, 'status'])
        ->name('magang.status');
});



// ================== Route Authenticated Pelamar ================== //
Route::middleware(['auth', 'role:pelamar'])->group(function () {

    // ===== Submit form pendaftaran pelamar =====
    Route::post('/form-pendaftaran', [PendaftaranController::class, 'store'])
        ->name('form.pendaftaran.store');

    // ===== Form pendaftaran pelamar =====
    // Mengecek status user agar:
    // - Jika status = 'off' → diarahkan ke halaman penolakan
    // - Jika sudah pernah mendaftar → diarahkan ke halaman terima kasih
    // - Jika belum → tampilkan form pendaftaran
    Route::get('/form-pendaftaran', function () {
        $user = auth()->user();

        if ($user->status === 'off') {
            return redirect()->route('penolakan.show', $user->id);
        }

        if (\App\Models\Pelamar::where('user_id', $user->id)->exists()) {
            return redirect()->route('form.terimakasih');
        }

        return view('pelamar.form-pendaftaran');
    })->name('form.pendaftaran');

    // ===== Halaman ucapan terima kasih setelah submit =====
    Route::get('/form-terimakasih', [PendaftaranController::class, 'terimaKasih'])
        ->name('form.terimakasih');

    // ===== Halaman penolakan pendaftaran =====
    Route::get('/penolakan/{id}', [PendaftaranController::class, 'showPenolakan'])
        ->name('penolakan.show');

    // ===== Halaman edit data pendaftaran pelamar =====
    Route::get('/form-pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])
        ->name('form-pendaftaran.edit');
    
    // ===== Aksi update data pendaftaran pelamar =====
    Route::put('/form-pendaftaran/{id}', [PendaftaranController::class, 'update'])
        ->name('form-pendaftaran.update');

    // ===== Halaman perbaikan berkas pendaftaran =====
    Route::get('/pelamar/perbaikan/{id}', [PendaftaranController::class, 'showPerbaikan'])
        ->name('perbaikan.show');
});

 
// ================== Breeze ==================
    // Profile (default Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Auth routes Breeze
require __DIR__.'/auth.php';
