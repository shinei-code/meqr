<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'backend'], function() {
/**
    Route::get('/', function () {
        return view('welcome');
    });
*/

    /**
    Route::get('/', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
*/


    Route::middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\DashboardController::class,'index'])->name('home');
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/user/csv', [\App\Http\Controllers\UserController::class, 'csv'])->name('user.csv');
        Route::get('/user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
        Route::resource('user', UserController::class)->except(['delete']);

        Route::get('/hospital/csv', [\App\Http\Controllers\HospitalController::class, 'csv'])->name('hospital.csv');
        Route::get('/hospital/{hospital}/delete', [\App\Http\Controllers\HospitalController::class, 'destroy'])->name('hospital.delete');
        Route::resource('hospital',\App\Http\Controllers\HospitalController::class)->except(['delete']);

        Route::get('/insurance/csv', [\App\Http\Controllers\InsuranceController::class, 'csv'])->name('insurance.csv');
        Route::get('/insurance/{insurance}/delete', [\App\Http\Controllers\InsuranceController::class, 'destroy'])->name('insurance.delete');
        Route::resource('insurance',\App\Http\Controllers\InsuranceController::class)->except(['delete']);

        Route::get('/code/csv', [\App\Http\Controllers\CodeController::class, 'csv'])->name('code.csv');
        Route::get('/code/{code}/delete', [\App\Http\Controllers\CodeController::class, 'destroy'])->name('code.delete');
        Route::resource('code',\App\Http\Controllers\CodeController::class)->except(['delete']);

    });
    require __DIR__.'/auth.php';
});
