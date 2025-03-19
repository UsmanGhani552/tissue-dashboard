<?php

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


Route::get('test-drive', function () {
    $folderIds = [
        \Config('services.google.tracking_1'),
        \Config('services.google.tracking_2'),
        \Config('services.google.tracking_3'),
        \Config('services.google.tracking_4'),
    ];
    $drive_data = [];

    foreach ($folderIds as $folderId) {
        $data = DriveTokenService::getDriveData($folderId);
        $drive_data = array_merge($drive_data, $data);
    }

    dd($drive_data);
});
