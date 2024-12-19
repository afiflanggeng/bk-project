<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// login admin/dokter
Route::get('/login', [MainController::class, 'showLoginPage'])->name('login');
Route::post('/login', [MainController::class, 'doLogin'])->name('login.submit');

// login psien
Route::get('/loginpasien', [PatientController::class, 'showLoginPasienForm'])->name('login_pasien');
Route::post('/loginpasien', [PatientController::class, 'doLoginPasien'])->name('login_pasien.submit');

// Route untuk halaman registrasi
Route::get('/register', [PatientController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [PatientController::class, 'register'])->name('register.submit');

// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::post('/logoutpasien', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('logoutpasien');


// route untuk admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/view/poli', [AdminController::class, 'showPoli'])->name('admin.poli');
    Route::get('/view/dokter', [AdminController::class, 'showDokter'])->name('admin.dokter');
    Route::get('/view/pasien', [AdminController::class, 'showPasien'])->name('admin.pasien');
    Route::get('/view/obat', [AdminController::class, 'showObat'])->name('admin.obat');

    // crud poli
    Route::get('/poli/create', [AdminController::class, 'createPoli'])->name('admin.poli.create');
    Route::post('/poli/create', [AdminController::class, 'addPoli'])->name('admin.poli.add');
    Route::get('/view/poli/edit/{id}', [AdminController::class, 'editPoli'])->name('admin.poli.edit');
    Route::put('/view/poli/edit/{id}', [AdminController::class, 'updatePoli'])->name('admin.poli.update');
    Route::delete('/poli/delete/{id}', [AdminController::class, 'hapusPoli'])->name('admin.poli.hapus');

    // crud dokter
    Route::get('/dokter/create', [AdminController::class, 'createDokter'])->name('admin.dokter.create');
    Route::post('/dokter/create', [AdminController::class, 'addDokter'])->name('admin.dokter.add');
    Route::get('/view/dokter/edit/{id}', [AdminController::class, 'editDokter'])->name('admin.dokter.edit');
    Route::put('/view/dokter/edit/{id}', [AdminController::class, 'updateDokter'])->name('admin.dokter.update');
    Route::delete('/dokter/delete/{id}', [AdminController::class, 'hapusDokter'])->name('admin.dokter.hapus');

    // crud pasien
    Route::get('/pasien/create', [AdminController::class, 'createPasien'])->name('admin.pasien.create');
    Route::post('/pasien/create', [AdminController::class, 'addPasien'])->name('admin.pasien.add');
    Route::get('/view/pasien/edit/{id}', [AdminController::class, 'editPasien'])->name('admin.pasien.edit');
    Route::put('/view/pasien/edit/{id}', [AdminController::class, 'updatePasien'])->name('admin.pasien.update');
    Route::delete('/pasien/delete/{id}', [AdminController::class, 'hapusPasien'])->name('admin.pasien.hapus');

    // crud obat
    Route::get('/obat/create', [AdminController::class, 'createObat'])->name('admin.obat.create');
    Route::post('/obat/create', [AdminController::class, 'addObat'])->name('admin.obat.add');
    Route::get('/view/obat/edit/{id}', [AdminController::class, 'editObat'])->name('admin.obat.edit');
    Route::put('/view/obat/edit/{id}', [AdminController::class, 'updateObat'])->name('admin.obat.update');
    Route::delete('/obat/delete/{id}', [AdminController::class, 'hapusObat'])->name('admin.obat.hapus');
});

Route::prefix('pasien')->middleware(['auth', 'role:pasien'])->group(function () {
    // Route::get('/dashboard_pasien', [PatientController::class, 'showDashboardPasien'])->name('pasien.dashboard_pasien');
    // Halaman daftar poli
    Route::get('/pilih-poli', [PatientController::class, 'pilihPoli'])->name('pasien.pilih-poli');
    Route::get('/pilih-dokter/{poli}', [PatientController::class, 'pilihDokter'])->name('pasien.pilih-dokter');
    Route::post('/pilih-dokter/{poli}', [PatientController::class, 'pilihDokterSubmit'])->name('pasien.pilih-dokter-submit');
    Route::get('/jadwal', [PatientController::class, 'lihatJadwal'])->name('pasien.jadwal');
});
Route::prefix('dokter')->middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dashboard', [DokterController::class, 'showDashboard'])->name('dokter.dashboard');
    Route::post('/submittanggal', [DokterController::class, 'simpantanggal'])->name('dokter.submittanggal');

    Route::get('/detailpemeriksaaan', [DokterController::class, 'detailPemeriksaan'])->name('dokter.detailpemeriksaaan');
    Route::post('/simpanpemeriksaan', [DokterController::class, 'simpanpemeriksaan'])->name('dokter.simpanpemeriksaan');
    Route::get("/historypasien", [DokterController::class, 'historypasien'])->name(name: 'dokter.historypasien');
    Route::get("/detailpasien", [DokterController::class, 'detailpasien'])->name(name: 'dokter.detailpasien');

    Route::get('/view/profile', [DokterController::class, 'showProfile'])->name('dokter.profile');
    Route::post('/update-akun', [DokterController::class, 'updateAkun'])->name('dokter.updateAkun');
    Route::get("/jadwaldokter", [DokterController::class, 'jadwaldokter'])->name(name: 'dokter.jadwaldokter');
    Route::post('/simpanjadwal', [DokterController::class, 'simpanjadwal'])->name('dokter.simpanjadwal');
});
