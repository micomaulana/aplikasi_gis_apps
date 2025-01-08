<?php

use App\Http\Controllers\PasienController;
use App\Http\Controllers\DesaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\LaporanFoggingController;
use App\Http\Controllers\LaporanKasusDBDController;
use App\Http\Controllers\OverviewStatistikPublishController;
use App\Http\Controllers\StatistikController;
use App\Models\OverviewStatistikPublish;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('pasiens', PasienController::class);
Route::resource('desas', DesaController::class);
Route::resource('dokters', DokterController::class);
Route::get('maps', [DesaController::class, 'maps'])->name('maps');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('data-dan-informasi', [DesaController::class, 'data_informasi_view'])->name('data_informasi_view');
Route::get('laporan', [DesaController::class, 'laporan_view'])->name('laporan_view');

Route::get('get_data_pasien_by_desa/{id}', [PasienController::class, 'get_data_pasien_by_desa'])->name('get_data_pasien_by_desa');

Route::get('get_data_pasien_alert', [PasienController::class, 'get_data_pasien_alert'])->name('get_data_pasien_alert');
Route::post('simpan_statistic', [StatistikController::class, 'store'])->name('simpan_statistic');
Route::get('edit-data-statistic/{id}', [StatistikController::class, 'edit'])->name('edit_data_statistik');
Route::put('update-data-statistik/{id}', [StatistikController::class, 'update'])->name('update-data-statistik');
Route::delete('delete-data-statistik/{id}', [StatistikController::class, 'destroy'])->name('delete-data-statistik');
Route::resource('publish_overview_statistiks', OverviewStatistikPublishController::class);
Route::get('get-jumlah-pasien-perdesa/{id}', [DesaController::class, 'hitung_kasus_dari_id_desa'])->name('hitung_kasus_dari_id_desa');
Route::resource('laporan-foggings', LaporanFoggingController::class);
Route::get('/generate-pdf/{id}', [LaporanFoggingController::class, 'generatePDF']);
Route::get('validasi_admin', [DesaController::class, 'validasi_pasien_admin_view'])->name('validasi_admin');
Route::get('laporan_masyarakat', [DesaController::class, 'laporan_masyarakat_view'])->name('laporan_masyarakat');
Route::get('tambah_laporan', [DesaController::class, 'tambah_laporan'])->name('tambah_laporan');
Route::post('simpan_laporan', [DesaController::class, 'simpan_laporan_masyarakat'])->name('simpan_laporan_masyarakat');
Route::get('get_laporan_dbd_by_id_pasien/{id}', [DesaController::class, 'get_laporan_dbd_by_id_pasien'])->name('get_laporan_dbd_by_id_pasien');

Route::put('update-laporan/{id}', [LaporanKasusDBDController::class, 'update'])->name('update.laporan');
Route::put('/laporan-tolak/{id}', [DesaController::class, 'tolakLaporan'])->name('laporan.tolak');
Route::get("generatePDFLaporan/{id}", [LaporanKasusDBDController::class, 'generatePDF']);
Route::get("validasi_kapus", [DesaController::class, 'validasi_kapus'])->name('validasi_kapus');
Route::get("update_foggings_status/{id}/{status}", [LaporanFoggingController::class, 'update_status_pengajuan_fogging'])->name("update_status_pengajuan_fogging");
Route::get('lihat_detail_foggings/{id}', [LaporanFoggingController::class, 'lihat_detail_foggings'])->name('lihat_detail_foggings');
Route::get("data_informasi_views", [OverviewStatistikPublishController::class, 'data_informasi_views'])->name('data_informasi_views');
Route::get('get-data-by-year/{year}',[OverviewStatistikPublishController::class,'getDataByYear']);
Route::get('get-data-statistik-by-year/{year}',[OverviewStatistikPublishController::class,'getDataStatistikByYear']);
Route::get('get-data-statistik-form-by-year/{year}',[OverviewStatistikPublishController::class,'getDataStatistikFormByYear']);
Route::get('get-pasien-detail/{idpasien}',[PasienController::class,'get_pasien_detail']);
route::get("landing_page",[DesaController::class, 'landing_page'])->name('landing_page_views');
route::get("dashboard_masyarakat",[DesaController::class, 'dashboard_masyarakat'])->name('dashboard_masyarakat');
// Route::post('/validasi_admin', [LaporanKasusDBDController::class, 'validasiLaporan']);