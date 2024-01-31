<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\QrController;



Route::any('/', [BaseController::class, 'index'])->name('index');
Route::any('/college', [BaseController::class, 'college'])->name('college');
Route::any('/generateQrCodeDetails', [QrController::class, 'generateQrCodeDetails'])->name('generateQrCodeDetails');
Route::any('/generateQrCode', [QrController::class, 'generateQrCode'])->name('generateQrCode');
