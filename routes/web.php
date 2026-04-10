<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSource\ExcelUploaderController;
use App\Http\Controllers\Reports\PendingPOController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

// use App\Http\Controllers\Forms\RefuelingFormController;
// use App\Http\Controllers\MasterFile\TiresController;
// use App\Http\Controllers\ProfileController;

// use App\Http\Controllers\MasterFile\VehicleController;
// use App\Http\Controllers\Test\TireLoggerController;
// use App\Http\Controllers\TireManagement\InstallationController;
// use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'web'])->name('dashboard');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'web']);

Route::prefix('data-source')->group(function(){
    Route::get('excel-uploader', [ExcelUploaderController::class, 'index'])->name('excel-upload.index');
});

Route::prefix('reports')->group(function(){
    Route::get('pending-po', [PendingPOController::class, 'index'])->name('pending-po.index');
});

// Route::get('/hash', function(){
//     echo Hash::make('admin');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::prefix('master-files')->group(function(){
//     Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicle.index');
//     Route::get('tires', [TiresController::class, 'index'])->name('tires.index');
// })->middleware(['auth', 'web']);

// Route::prefix('tire-management')->group(function(){
//     Route::get('installation-replacement', [InstallationController::class, 'index'])->name('installation.index');
// })->middleware(['auth', 'web']);

// Route::prefix('forms')->group(function(){
//     Route::get('refueling-form', [RefuelingFormController::class, 'index'])->name('refueling-form.index');
//     // Route::get('tires', [TiresController::class, 'index'])->name('tires.index');
// });//->middleware(['auth', 'web']);

// Route::prefix('test')->group(function(){
//     Route::get('tire-logger', [TireLoggerController::class, 'index']);
// });

// // Route::get('/ping',function(){
// //     $apiKey = 'vbsc1r3pssdc1nlnuiw9gd60msuaatc1';
// //     $apiSecret = 'qlwy6ugzxkoqalwak0xwou5v6vaxlanf';

// //     $t = time(); // current UNIX timestamp

// //     $message = "api-key{$apiKey}t{$t}";
// //     $signature = hash_hmac('sha256', $message, $apiSecret);

// //     $url = "https://api.weatherlink.com/v2/stations"
// //         . "?api-key={$apiKey}"
// //         . "&t={$t}"
// //         . "&api-signature={$signature}";

// //     $response = file_get_contents($url);

// //     return json_decode($response);
// // });

// // Route::get('get-data',[WeatherLinkController::class,'getData']);

require __DIR__.'/auth.php';
