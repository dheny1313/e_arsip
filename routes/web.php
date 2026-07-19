<?php

use App\Models\Arsip;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/arsip/{arsip}/secure-access', function (Arsip $arsip) {
    // Memeriksa file di disk 'local' (Private)
    if (!Storage::disk('local')->exists($arsip->file_arsip)) {
        abort(404, 'File tidak ditemukan.');
    }

    $path = Storage::disk('local')->path($arsip->file_arsip);

    // Mengembalikan file secara aman dengan header inline
    return response()->file($path, [
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
})->name('arsip.secure')->middleware(['auth']);
