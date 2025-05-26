<?php

use App\Http\Controllers\PersonalisBsm2Controller;
use App\Services\DriveTokenService;
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


Route::get('process-delete-files', [PersonalisBsm2Controller::class, 'processDeleteFiles'])->name('process.delete.files');


Route::post('/import',[PersonalisBsm2Controller::class,'import'])->name('personalis_bsm_2.import');
Route::get('/start-queue',[PersonalisBsm2Controller::class,'startQueue'])->name('personalis_bsm_2.start-queue');
