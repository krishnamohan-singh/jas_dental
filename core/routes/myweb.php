<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/test123', [TestController::class, 'index']);
// Route::controller('TestController')->prefix('test')->name('test.')->group(function () {
//     Route::get('/', 'index')->name('index');

// });

Route::get('/test', function () {
    return "Test route is working!";
});