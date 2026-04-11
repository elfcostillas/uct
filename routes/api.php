<?php

// use App\Http\Controllers\MasterFile\TiresController;
// use App\Http\Controllers\MasterFile\VehicleController;
// use App\Http\Controllers\ScriptController;
// use App\Http\Controllers\TireManagement\InstallationController;

use App\Http\Controllers\DataSource\ExcelUploaderController;
use App\Http\Controllers\Reports\APDailyController;
use App\Http\Controllers\Reports\PendingPOController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('data-source')->group(function(){
    Route::prefix('excel-uploader')->group(function(){
        Route::post('upload', [ExcelUploaderController::class, 'upload'])->name('excel-upload.upload');
      
    });
});

Route::prefix('reports')->group(function(){
    Route::get('pending-po/download', [PendingPOController::class, 'download'])->name('pending-po.download');

    Route::get('ap-daily/download', [APDailyController::class, 'download'])->name('ap-daily.download');
    
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('copy-employees', [ScriptController::class, 'copyEmployees']);
// Route::get('copy-suppliers', [ScriptController::class, 'copySuppliers']);
// Route::get('copy-items', [ScriptController::class, 'copyItems']);


// Route::middleware('auth:sanctum')->prefix('master-files')->group(function(){
//     Route::prefix('vehicles')->group(function(){
//         Route::post('create', [VehicleController::class, 'create'])->name('vehicle.create');
//         Route::post('update', [VehicleController::class, 'update'])->name('vehicle.update');
//     });

//     Route::prefix('tires')->group(function(){
//         Route::post('create', [TiresController::class, 'create'])->name('tires.create');
//         Route::post('update', [TiresController::class, 'update'])->name('tires.update');
//     });
   
// });

// Route::middleware('auth:sanctum')->prefix('tire-management')->group(function(){

//     Route::prefix('positions')->group(function(){
//         // Route::post('create', [TiresController::class, 'create'])->name('tires.create');
//         Route::post('update', [InstallationController::class, 'update'])->name('tires.update');
    
//     });
   

