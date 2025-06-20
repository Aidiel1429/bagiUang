<?php

use App\Livewire\App\Akun;
use App\Livewire\App\Alokasi;
use App\Livewire\App\Dashboard;
use App\Livewire\App\Transaksi;
use App\Livewire\Auth\Daftar;
use App\Livewire\Auth\Keluar;
use App\Livewire\Auth\Masuk;
use App\Livewire\LandingPage;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPage::class)->name('Home');

Route::middleware('guest')->group(function () {
    Route::get('/login', Masuk::class)->name('login');
    Route::get('/daftar', Daftar::class)->name('daftar');
});

Route::middleware('auth')->group(function () {
    Route::get('/dasbor', Dashboard::class)->name('dashboard');
    Route::get('/keluar', Keluar::class)->name('keluar');
    Route::get('/alokasi', Alokasi::class)->name('alokasi');
    Route::get('/transaksi', Transaksi::class)->name('transaksi');
    Route::get('akun', Akun::class)->name('akun');
});