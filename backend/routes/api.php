<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/hospitals', [\App\Http\Controllers\Api\HospitalController::class, 'index'])->name('hospitals');
Route::get('/hospitals/type/{type}', [\App\Http\Controllers\Api\HospitalController::class, 'type'])->name('hospitals.type');
Route::get('/hospital/code/{code}', [\App\Http\Controllers\Api\HospitalController::class, 'code'])->name('hospitals.code');
Route::get('/hospital/{id}', [\App\Http\Controllers\Api\HospitalController::class, 'show'])->name('hospital.show');

Route::get('/insurances', [\App\Http\Controllers\Api\InsuranceController::class, 'index'])->name('insurances');
Route::get('/insurances/type/{type}', [\App\Http\Controllers\Api\InsuranceController::class, 'type'])->name('insurances.type');
Route::get('/insurance/code/{code}', [\App\Http\Controllers\Api\InsuranceController::class, 'code'])->name('insurances.code');
Route::get('/insurance/{id}', [\App\Http\Controllers\Api\InsuranceController::class, 'show'])->name('insurance.show');

Route::get('/codes', [\App\Http\Controllers\Api\CodeController::class, 'index'])->name('codes');
Route::get('/codes/category/{category}', [\App\Http\Controllers\Api\CodeController::class, 'category'])->name('codes.category');
Route::get('/code/one/{category}/{key}', [\App\Http\Controllers\Api\CodeController::class, 'one'])->name('code.one');
Route::get('/code/{id}', [\App\Http\Controllers\Api\CodeController::class, 'show'])->name('code.show');
Route::post('/uid', [\App\Http\Controllers\Api\CodeController::class, 'uid'])->name('code.uid');
