<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserDosenController;
use App\Http\Controllers\Admin\AdminAgendaController;
use App\Http\Controllers\Admin\UserDirmawaController;
use App\Http\Controllers\Admin\AdminProposalController;
use App\Http\Controllers\Admin\UserMahasiswaController;
use App\Http\Controllers\Dosen\DosenProposalController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Dirmawa\DirmawaDashboardController;
use App\Http\Controllers\Dirmawa\DirmawaProposalController;
use App\Http\Controllers\Dosen\DosenDashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Mahasiswa\MahasiswaAgendaController;
use App\Http\Controllers\Mahasiswa\MahasiswaProposalController;
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->as('admin.')->middleware(['user-access:admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => 'dosen', 'as' => 'dosen.'], function () {
            Route::get('/', [UserDosenController::class, 'index'])->name('index');
            Route::get('/create', [UserDosenController::class, 'create'])->name('create');
            Route::post('/store', [UserDosenController::class, 'store'])->name('store');
            Route::get('/{id}/edit',     [UserDosenController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserDosenController::class, 'update'])->name('update');
            Route::delete('/destroy', [UserDosenController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => 'mahasiswa', 'as' => 'mahasiswa.'], function () {
            Route::get('/', [UserMahasiswaController::class, 'index'])->name('index');
            Route::get('/create', [UserMahasiswaController::class, 'create'])->name('create');
            Route::post('/store', [UserMahasiswaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserMahasiswaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserMahasiswaController::class, 'update'])->name('update');
            Route::delete('/destroy', [UserMahasiswaController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => 'dirmawa', 'as' => 'dirmawa.'], function () {
            Route::get('/', [UserDirmawaController::class, 'index'])->name('index');
            Route::get('/create', [UserDirmawaController::class, 'create'])->name('create');
            Route::post('/store', [UserDirmawaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserDirmawaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserDirmawaController::class, 'update'])->name('update');
            Route::delete('/destroy', [UserDirmawaController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => 'proposal', 'as' => 'proposal.'], function () {
            Route::get('/', [AdminProposalController::class, 'index'])->name('index');
            Route::get('/create', [AdminProposalController::class, 'create'])->name('create');
            Route::get('/arsip', [AdminProposalController::class, 'arsipProposal'])->name('arsip');
            Route::post('/store', [AdminProposalController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminProposalController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminProposalController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminProposalController::class, 'update'])->name('update');
            Route::delete('/destroy', [AdminProposalController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'agenda', 'as' => 'agenda.'], function () {
            Route::get('/', [AdminAgendaController::class, 'index'])->name('index');
            Route::get('/create', [AdminAgendaController::class, 'create'])->name('create');
            Route::post('/store', [AdminAgendaController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminAgendaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminAgendaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminAgendaController::class, 'update'])->name('update');
            Route::delete('/destroy', [AdminAgendaController::class, 'destroy'])->name('destroy');
        });
    });
});

// Mahasiswa
Route::middleware(['auth'])->group(function () {
    Route::prefix('mahasiswa')->as('mahasiswa.')->middleware(['user-access:mahasiswa'])->group(function () {
        Route::get('/', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => 'proposal', 'as' => 'proposal.'], function () {
            Route::get('/', [MahasiswaProposalController::class, 'index'])->name('index');
            Route::get('/create', [MahasiswaProposalController::class, 'create'])->name('create');
            Route::get('/arsip', [MahasiswaProposalController::class, 'arsipProposal'])->name('arsip');
            Route::post('/store', [MahasiswaProposalController::class, 'store'])->name('store');
            Route::get('/{id}', [MahasiswaProposalController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [MahasiswaProposalController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MahasiswaProposalController::class, 'update'])->name('update');
            Route::delete('/destroy', [MahasiswaProposalController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'agenda', 'as' => 'agenda.'], function () {
            Route::get('/', [MahasiswaAgendaController::class, 'index'])->name('index');
            Route::get('/create', [MahasiswaAgendaController::class, 'create'])->name('create');
            Route::post('/store', [MahasiswaAgendaController::class, 'store'])->name('store');
            Route::get('/{id}', [MahasiswaAgendaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [MahasiswaAgendaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MahasiswaAgendaController::class, 'update'])->name('update');
            Route::delete('/destroy', [MahasiswaAgendaController::class, 'destroy'])->name('destroy');
        });
    });
});

//Dosen
Route::middleware(['auth'])->group(function () {
    Route::prefix('dosen')->as('dosen.')->middleware(['user-access:dosen'])->group(function () {
        Route::get('/', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => 'proposal', 'as' => 'proposal.'], function () {
            Route::get('/', [DosenProposalController::class, 'index'])->name('index');
            Route::put('/{id}', [DosenProposalController::class, 'verifikasi'])->name('verifikasi');
        });
    });
});

//Dirmawa
Route::middleware(['auth'])->group(function () {
    Route::prefix('dirmawa')->as('dirmawa.')->middleware(['user-access:dirmawa'])->group(function () {
        Route::get('/', [DirmawaDashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => 'proposal', 'as' => 'proposal.'], function () {
            Route::get('/', [DirmawaProposalController::class, 'index'])->name('index');
            Route::put('/{id}', [DirmawaProposalController::class, 'verifikasi'])->name('verifikasi');
        });
    });
});
