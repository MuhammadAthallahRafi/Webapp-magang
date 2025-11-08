<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pelamar\PendaftaranController;//punya role pelamar

use App\Http\Controllers\Admin\AdminController;//punya admin dashboard
use App\Http\Controllers\Admin\PelamarController;//punya admin pengaturan pelamar
use App\Http\Controllers\Admin\PelamarDitolakController;//punya admin pengaturan pelamar yang di tolak
use App\Http\Controllers\Admin\PesertaController;//punya admin pengaturan peserta magang
use App\Http\Controllers\Admin\AkunUserController;//punya admin pengaturan akun universal
use App\Http\controllers\Admin\PesertaLulusController;//punya admin /pengaturan peserta lulus
use App\Http\Controllers\Admin\PermohonanPeriodeController as AdminPermohonanPeriodeController;//punya admin pengaturan permohonan penyesuaian peserta magang
use App\Http\Controllers\Admin\AdminPeriodeReviewController;//punya admin extand pengaturan permohonan penyesuaian peserta magang
use App\Http\Controllers\PeriodeActivationController;// //punya admin update untuk pertamabhan periode trigger manual

use App\Http\Controllers\Adminunitkerja\PesertaMagangUnitKerjaController;//punya admin unitkerja
use App\Http\Controllers\Adminunitkerja\PesertaLulusController as PesertaunitLulusController;//punya admin unitkerja
use App\Http\Controllers\Adminunitkerja\PermohonanPeriodeController as AdminunitkerjaPermohonanPeriodeController;//punya admin unitkerja

use App\Http\Controllers\Peserta\PesertaMagangController;//punya peserta magang
use App\Http\Controllers\Peserta\PermohonanPeriodeController;//punya peserta magang

use App\Http\Controllers\AkunController;//punya peserta magang

// Landing Page
Route::get('/', function () {
    return view('landing');
});

//halaman jika status user off lempar halaman hampa
Route::get('/halamanoff', function () {
    return view('halamanoff');
})->name('halamanoff');

    Route::get('/redirect-role', function () {
        $user = auth()->user();

        if ($user->status === 'off') {
            return redirect('/halamanoff');
        } 
        if ($user->role === 'admin') {
            return redirect('/dashboard/admin');

        } elseif ($user->role === 'admin-unitkerja') {
            return redirect('/dashboard/admin-unitkerja');

        } elseif ($user->role === 'magang') {
            if ($user->peserta && $user->peserta->status === 'mundur') {
                return redirect()->route('dashboard.magang', $user->peserta->id);
            }
            if ($user->peserta && $user->peserta->status === 'lulus') {
                return redirect()->route('dashboard.magang', $user->peserta->id);
            }
            return redirect('/dashboard/magang');

        } elseif ($user->role === 'pelamar') { 
            if ($user->pelamar && $user->pelamar->status === 'ditolak') { 
                return redirect()->route('pelamar.center', $user->pelamar->id); 
            } 
            elseif ($user->pelamar && $user->pelamar->status === 'perbaikan') 
            { 
                return redirect()->route('pelamar.center', $user->pelamar->id); 
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




// ================== Route Authenticated Admin================== //
Route::middleware(['auth', 'role:admin'])->group(function () {

Route::post('/admin/activate-today-periods', [PeriodeActivationController::class, 'activateToday'])
    ->name('admin.activate-today-periods');

    // ================== Admin ================== //
    // Masuk Dashboard Admin
   Route::get('/dashboard/admin', [AdminController::class, 'index'])
        ->name('dashboard.admin');

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
    // route untuk perbaikan pelamar
    Route::post('/admin/pelamar/{id}/perbaikan', [PelamarController::class, 'perbaikan'])
    ->name('admin.pelamar.perbaikan');
    // route untuk override tanggal mulai
    Route::put('pelamar/{id}/update-tanggal-mulai', [PelamarController::class, 'updateTanggalMulai'])
    ->name('pelamar.updateTanggalMulai');
    // route untuk override tanggal selesai
    Route::put('pelamar/{id}/update-tanggal-selesai', [PelamarController::class, 'updateTanggalSelesai'])
    ->name('pelamar.updateTanggalSelesai');

    // mengambil data pelamar    
    //Route::get('/admin/peserta-magang', [PelamarController::class, 'daftarMagang'])
        //->name('admin.peserta-magang');

    
   


    
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
    //Route::get('/admin/peserta-magang', [PelamarDitolakController::class, 'daftarMagang'])
        //->name('admin.peserta-magang');

    // route untuk perbaikan pelamar
    Route::post('/admin/pelamarditolak/{id}/perbaikan', [PelamarDitolakController::class, 'perbaikan'])
    ->name('admin.pelamarditolak.perbaikan');
    // route untuk override tanggal mulai pelamar yang di tolak
     Route::put('pelamarditolak/{id}/update-tanggal-mulai', [PelamarDitolakController::class, 'updateTanggalMulai'])
    ->name('pelamarditolak.updateTanggalMulai');
    // route untuk override tanggal selesai pelamar yang di tolak
    Route::put('pelamarditolak/{id}/update-tanggal-selesai', [PelamarDitolakController::class, 'updateTanggalSelesai'])
    ->name('pelamarditolak.updateTanggalSelesai');
    

    //========= Route Power peserta magang (Admin) ============//
    // Halaman Admin melihat peserta magang
    Route::get('/admin/peserta-magang', [PesertaController::class, 'index'])
    ->name('admin.peserta-magang');
    // Halaman Admin melihat Detail peserta magang
    Route::get('/admin/peserta-magang/{id}', [PesertaController::class, 'show'])
        ->name('admin.peserta-magang.lihat');
    // Route Admin Untuk meluluskan
    Route::post('/admin/peserta-magang/{id}/lulus', [PesertaController::class, 'lulus'])
    ->name('admin.peserta-magang.lulus');
    // Route Admin Untuk memundurkan
    Route::post('/admin/peserta-magang/{id}/mundur', [PesertaController::class, 'mundur'])
    ->name('admin.peserta-magang.mundur');
    // Riwayat Absensi peserta Magang
    Route::get('/admin/peserta-magang/{id}/absensi', [PesertaController::class, 'absensi'])
        ->name('admin.peserta-magang.absensi');
    // Route Admin Untuk Update Keterangan
    Route::post('/admin/peserta-magang/{id}/update-keterangan', [PesertaController::class, 'updateKeterangan'])
    ->name('admin.peserta-magang.update-keterangan');
    // Ambil data peserta dan semua periode magangnya
    Route::get('/admin/peserta-magang/{id}/periode', [PesertaController::class, 'periode'])
        ->name('admin.peserta-magang.periode');
    


    //========= Route Power permohonan periode (Admin) ============//
    // Halaman Admin melihat permohonan periode
    Route::get('/admin/permohonan-periode', [AdminPermohonanPeriodeController::class, 'index'])
    ->name('admin.permohonan-periode');
    // Approve
    Route::post('/admin/permohonan/{id}/approve', [AdminPermohonanPeriodeController::class, 'approve'])
    ->name('admin.permohonan-periode.approve');
    //Tolak
    Route::post('/admin/permohonan/{id}/reject', [AdminPermohonanPeriodeController::class, 'reject'])
    ->name('admin.permohonan-periode.reject');


    // lihat detail peserta yang melamar kembali (controller pinjaman)
    Route::get('/admin/permohonan-periode/{id}/lihat', [AdminPeriodeReviewController::class, 'lihat'])
    ->name('admin.permohonan-periode.lihat');
    // Terima Peserta yang magang kembali (controller pinjaman)
    Route::post('/admin/pelamar/{id}/approve', [AdminPeriodeReviewController::class, 'approve'])
    ->name('admin.permohonan-periode.approve');
    // Tolak Peserta yang magang kembali (controller pinjaman)
    Route::post('/admin/pelamar/{id}/reject', [AdminPeriodeReviewController::class, 'reject'])
    ->name('admin.permohonan-periode.reject');
    // route untuk override tanggal mulai permohonan penyesuaian periode
    Route::put('/admin/permohonan-periode/{id}/update-tanggal-mulai', [AdminPeriodeReviewController::class, 'updateTanggalMulai'])
    ->name('admin.permohonan-periode.updateTanggalMulai');
     // route untuk override tanggal selesai permohonan penyesuaian periode
    Route::put('/admin/permohonan-periode/{id}/update-tanggal-selesai', [AdminPeriodeReviewController::class, 'updateTanggalSelesai'])
    ->name('admin.permohonan-periode.updateTanggalSelesai');




    //========= Route Power peserta lulus (Admin) ============//
    // Halaman Admin melihat  peserta lulus 
    Route::get('/admin/peserta-lulus', [\App\Http\Controllers\Admin\PesertaLulusController::class, 'index'])
        ->name('admin.peserta-lulus.index');
    // Cetak Sertifikat
    Route::get('/admin/peserta-lulus/{id}/sertifikat', [\App\Http\Controllers\Admin\PesertaLulusController::class, 'cetakSertifikat'])
        ->name('admin.peserta-lulus.sertifikat');



    });

        // ========= Route Power Akun User (Admin) ========= //
        Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin']) // opsional: tambahkan middleware jika perlu
            ->group(function () {

        // 🔹 Resource utama (index, edit, update, destroy)
        Route::resource('akun-user', AkunUserController::class)
            ->except(['create', 'store', 'show']);

        // 🔹 Khusus untuk admin membuat unit kerja
        Route::get('akun-user/create-unitkerja', [AkunUserController::class, 'createUnitkerja'])
            ->name('akun-user.create-unitkerja');
        // 🔹 Khusus untuk simpan admin membuat unit kerja
        Route::post('akun-user/store-unitkerja', [AkunUserController::class, 'storeUnitkerja'])
            ->name('akun-user.store-unitkerja');

        // 🔹 Power toggle status (on/off)
        Route::post('akun-user/{id}/toggle-status', [AkunUserController::class, 'toggleStatus'])
            ->name('akun-user.toggle');
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


        //========= Route Power penyesuian periode peserta magang (Admin unit kerja) ============//
    //lihat seluruh permintaan penyesuaian periode peserta unit kerja
    Route::get('/admin-unitkerja/permohonan-periode', [AdminunitkerjaPermohonanPeriodeController::class, 'index'])
       ->name('admin-unitkerja.permohonan-periode');
    // Approve
    Route::post('/admin-unitkerja/permohonan/{id}/approve', [AdminunitkerjaPermohonanPeriodeController::class, 'approve'])
    ->name('admin-unitkerja.permohonan.approve');
    //Tolak
    Route::post('/admin-unitkerja/permohonan/{id}/reject', [AdminunitkerjaPermohonanPeriodeController::class, 'reject'])
    ->name('admin-unitkerja.permohonan.reject');
    //detail
    Route::get('/admin-unitkerja/permohonan-periode/{id}/lihat', [AdminunitkerjaPermohonanPeriodeController::class, 'lihat'])
    ->name('admin-unitkerja.permohonan.lihat');
    // route untuk override tanggal selesai penyesuaian peserta unitkerja
     Route::put('/admin-unitkerja/permohonan-periode/{id}/update-tanggal-mulai', [AdminunitkerjaPermohonanPeriodeController::class, 'updateTanggalMulai'])
    ->name('admin-unitkerja.permohonan-periode.updateTanggalMulai');
    // route untuk override tanggal selesai penyesuaian peserta unitkerja
    Route::put('/admin-unitkerja/permohonan-periode/{id}/update-tanggal-selesai', [AdminunitkerjaPermohonanPeriodeController::class, 'updateTanggalSelesai'])
    ->name('admin-unitkerja.permohonan-periode.updateTanggalSelesai');

    //========= Route Power peserta magang lulus (Admin unit kerja) ============//
    //lihat seluruh peserta unit kerja lulus
    Route::get('/admin-unitkerja/peserta-lulus', [PesertaunitLulusController::class, 'index'])
        ->name('admin-unitkerja.peserta-lulus.index');
    // Cetak Sertifikat
    Route::get('/admin-unitkerja/peserta-lulus/{id}/sertifikat', [PesertaunitLulusController::class, 'cetakSertifikat'])
        ->name('admin-unitkerja.peserta-lulus.sertifikat');

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

    Route::put('/magang/data-diri/{id}', [PesertaMagangController::class, 'updateDataDiri'])
    ->name('magang.data-diri.update');

  
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

    // edit permohonan periode sesuai id permohanan periode
    Route::put('/magang/permohonan/{id}', [PermohonanPeriodeController::class, 'updatePermohonan'])
        ->name('magang.permohonan.update');

    // Tambahkan route untuk batalkan/delete permohonan
    Route::delete('/magang/permohonan/{id}', [PermohonanPeriodeController::class, 'batalkanPermohonan'])
        ->name('magang.permohonan.batalkan');

    // ===== Permohonan magang kembali (setelah mundur) =====
    Route::post('/magang/permohonan-periode/permohonanmagangkembali', [PermohonanPeriodeController::class, 'permohonanMagangKembali'])
        ->name('magang.periode.permohonanmagangkembali');
     // ===== edit Permohonan magang kembali (setelah mundur) =====
    Route::put('/magang/permohonan-periode/permohonanmagangkembali', [PermohonanPeriodeController::class, 'updatePermohonanMagangKembali'])
        ->name('magang.periode.permohonanmagangkembali.update');

    // ===== check Permohonan magang kembali (setelah mundur) =====
    Route::get('/magang/check-pending-permohonan', [PermohonanPeriodeController::class, 'checkPendingPermohonan'])
        ->name('magang.check-pending-permohonan');
});



// ================== Route Authenticated Pelamar ================== //
Route::middleware(['auth', 'role:pelamar'])->group(function () {

    Route::get('/pelamar/center', [PendaftaranController::class, 'center'])
    ->name('pelamar.center')
    ->middleware(['auth', 'role:pelamar']);


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

// ===== Halaman  berkas pendaftaran =====
    Route::get('/pelamar/data-diri', [PendaftaranController::class, 'dataDiri'])
    ->name('pelamar.data-diri');

        if ($user->status === 'off') {
            return redirect()->route('pelamar.center', $user->id);
        }
        return view('pelamar.form-pendaftaran');
    })->name('form.pendaftaran');

     Route::get('/pelamar/data-diri', [PendaftaranController::class, 'dataDiri'])
    ->name('pelamar.data-diri');

    // ===== Halaman edit data pendaftaran pelamar =====
    Route::get('/form-pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])
        ->name('form-pendaftaran.edit');
    
    // ===== Aksi update data pendaftaran pelamar =====
    Route::put('/form-pendaftaran/{id}', [PendaftaranController::class, 'update'])
        ->name('form-pendaftaran.update');

    

    
});
    //masuk halaman akun setting
    Route::get('/akun-setting', [AkunController::class, 'edit'])->name('akun.setting');
    //masuk halaman akun setting ganti password dan username
    Route::post('/akun-setting', [AkunController::class, 'update'])->name('akun.update');
 
// ================== Breeze ==================
    // Profile (default Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Auth routes Breeze
require __DIR__.'/auth.php';
