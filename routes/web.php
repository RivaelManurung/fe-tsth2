<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangCategoryController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.token')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('post.login')->middleware('guest');
});



Route::middleware('auth.session')->group(function () {
    Route::post('/logout', [AuthController::class, 'handleLogout'])->name('auth.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/scan-result', function () {
        $data = request()->query('data');
        return view('scan-result', compact('data'));
    });

    Route::get('/middleware-test', function () {
        return 'Middleware OK';
    })->middleware('refresh.permissions');

    Route::get('/user_profile', function () {
        return view('frontend.profile.user_profile');
    })->name('profile.user_profile');
    Route::get('/user_profile/change-password', function () {
        return view('frontend.profile.ganti_password');
    })->name('profile.ganti-password');

    Route::get('laporan-transaksi', [LaporanController::class, 'laporanTrans'])->name('laporan.transaksi');
    Route::get('laporan-transaksi/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.transaksi.exportPDF');

    Route::get('laporan-stok',[LaporanController::class, 'laporanStok'])->name('laporan.stok');


    Route::resource('barangs', BarangController::class);
    Route::get('/export-barang-pdf', [BarangController::class, 'exportPDFALL'])->name('barangs.exportPDFALL');
    Route::get('/barangs/export-pdf/{id}', [BarangController::class, 'exportPDF'])->name('barangs.exportPDF');

    Route::get('laporantransaksi', [LaporanController::class, 'laporantransaksi']);
    Route::get('/laporan-transaksi/export-pdf', [LaporanController::class, 'generateTransaksiReportPdf'])->name('transactions.exportPdf');
    Route::get('/laporan-transaksi/export-pdf/{id}', [LaporanController::class, 'exportLaporanTransaksiPDFByType'])->name('transactions.exportPdfByType');
    Route::get('/laporan-transaksi/export-excel/{id}', [LaporanController::class, 'generateTransaksiTypeReportexcel']);
    Route::get('/laporan-transaksi/export-excel', [LaporanController::class, 'generateAllTransaksiexcel']);

    Route::get('laporanstok', [LaporanController::class, 'laporanstok']);
    Route::get('laporan-stok/pdf', [LaporanController::class, 'exportStokPdf'])->name('laporan.stok.exportPDF');
    Route::get('laporan-stok/excel', [LaporanController::class, 'exportStokExcel']);

    Route::get('/barang/refresh-qrcodes', [BarangController::class, 'refreshQRCodes'])->name('barang.refresh-qrcodes');
    Route::get('/search-barang', [TransactionController::class, 'searchBarang'])->name('search.barang');

    Route::resource('satuans', SatuanController::class)->middleware('check.permission:view_satuan');
    Route::resource('gudangs', GudangController::class)->middleware('check.permission:view_gudang');
    Route::resource('jenis-barangs', JenisBarangController::class)->middleware('check.permission:view_jenis_barang');
    Route::resource('barang-categories', BarangCategoryController::class)->middleware('check.permission:view_category_barang');
    Route::resource('transaction-types', TransactionTypeController::class);
    Route::resource('roles', RoleController::class)->middleware('check.permission:view_role');
    Route::resource('users', UserController::class)->middleware('check.permission:view_user');
    Route::resource('webs', WebController::class);
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');
    Route::get('transactions/scan', [TransactionController::class, 'form'])->name('transactions.tambah');
    Route::post('/barcode/check', [TransactionController::class, 'check'])->name('barcode.check');
    Route::get('/barcode/reset', [TransactionController::class, 'reset'])->name('barcode.reset');
    Route::post('/barcode/remove', [TransactionController::class, 'remove'])->name('barcode.remove');


Route::get('/select-role', [PermissionController::class, 'selectRole'])->name('permissions.index');
Route::get('select-role/permissions', [PermissionController::class, 'show'])->name('permissions.show');
Route::post('/permissions/toggle', [PermissionController::class, 'toggle'])->name('permissions.toggle');
});

Route::get('/error', function () {
    return view('error.error');
})->name('error');

