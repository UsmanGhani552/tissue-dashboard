<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonthlyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeeklyController;
use App\Http\Controllers\Sheet1Controller;
use App\Http\Controllers\Sheet2Controller;
use App\Http\Controllers\FindMatchController;
use App\Http\Controllers\ManifestController;
use App\Http\Controllers\PersonalisBsm2Controller;
use App\Http\Controllers\PersonalisBsmController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\RecompilationController;
use App\Models\Receiving;
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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::controller(PermissionController::class)->name('permission.')->group(function () {
        Route::get('permissions', 'index')->name('index');
        Route::get('permission-create', 'create')->name('create');
        Route::post('permission-store', 'store')->name('store');
        Route::get('permission-edit-{permission}', 'edit')->name('edit');
        Route::post('permission-update-{permission}', 'update')->name('update');
        Route::get('permission-destroy-{permission}', 'destroy')->name('destroy');
    });

    Route::controller(RoleController::class)->name('role.')->group(function () {
        Route::get('roles', 'index')->name('index');
        Route::get('role-create', 'create')->name('create');
        Route::post('role-store', 'store')->name('store');
        Route::get('role-edit-{role}', 'edit')->name('edit');
        Route::post('role-update-{role}', 'update')->name('update');
    });

    Route::controller(UserController::class)->name('user.')->group(function () {
        Route::get('users', 'index')->name('index');
        Route::get('user-create', 'create')->name('create');
        Route::post('user-store', 'store')->name('store');
        Route::get('user-edit-{user}', 'edit')->name('edit');
        Route::post('user-update-{user}', 'update')->name('update');
        Route::post('user-delete-{user}', 'delete')->name('delete');
    });

    // Route::controller(AddAdminController::class)->prefix('/admin/add-admin')->name('add-admin.')->group(function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::get('/create', 'create')->name('create');
    //     Route::post('/store', 'store')->name('store');
    //     Route::get('/edit/{addAdmin}', 'edit')->name('edit');
    //     Route::post('/update/{addAdmin}', 'update')->name('update');
    //     Route::get('/destroy/{addAdmin}', 'destroy')->name('destroy');
    // });
    Route::get('/sheet-1',[Sheet1Controller::class,'index'])->name('sheet1.index');
    Route::post('/import-sheet1',[Sheet1Controller::class,'import'])->name('import-sheet1');
    Route::get('/sheet1-show-{sheet1}',[Sheet1Controller::class,'show'])->name('sheet1-show');
    Route::get('/sheet1-delete-{sheet1}',[Sheet1Controller::class,'delete'])->name('sheet1-delete');
    
    
    Route::get('/find-match',[FindMatchController::class,'compareSubmitters'])->name('find-match');
    Route::get('/recompile',[RecompilationController::class,'recompile'])->name('recompile');
    Route::get('/recompile/export', [RecompilationController::class, 'exportToExcel'])->name('recompile.export');
    
    Route::get('/sheet-2',[Sheet2Controller::class,'index'])->name('sheet2.index');
    Route::post('/import-sheet2',[Sheet2Controller::class,'import'])->name('import-sheet2');
    Route::get('/sheet2-show-{sheet2}',[Sheet2Controller::class,'show'])->name('sheet2-show');
    Route::get('/sheet2-delete-{sheet2}',[Sheet2Controller::class,'delete'])->name('sheet2-delete');

    Route::get('/receiving',[ReceivingController::class,'index'])->name('receiving.index');
    Route::post('/import-receiving',[ReceivingController::class,'import'])->name('import-receiving');
    Route::get('/receiving-show-{receiving}',[ReceivingController::class,'show'])->name('receiving-show');
    Route::get('/receiving-delete-{receiving}',[ReceivingController::class,'delete'])->name('receiving-delete');
    
    Route::get('/manifest',[ManifestController::class,'index'])->name('manifest.index');
    Route::post('/import-manifest',[ManifestController::class,'import'])->name('import-manifest');
    Route::get('/manifest-show-{manifest}',[ManifestController::class,'show'])->name('manifest-show');
    Route::get('/manifest-delete-{manifest}',[ManifestController::class,'delete'])->name('manifest-delete');

    Route::get('/personalis_bsm',[PersonalisBsmController::class,'index'])->name('personalis_bsm');
    Route::post('/import-personalis_bsm',[PersonalisBsmController::class,'import'])->name('personalis_bsm.import');
    Route::get('/personalis_bsm/show',[PersonalisBsmController::class,'show'])->name('personalis_bsm.show');
    Route::get('/personalis_bsm/delete/{id}',[PersonalisBsmController::class,'delete'])->name('personalis_bsm.delete');
    // Route::get('/PersonalisBsmController-{PersonalisBsmControllerPersonalisBsmController::class,'show'])->name('PersonalisBsmController');
    // Route::get('/PersonalisBsmController-{PersonalisBsmControllerPersonalisBsmController::class,'delete'])->name('PersonalisBsmController');
    
    Route::get('/personalis_bsm_2',[PersonalisBsm2Controller::class,'index'])->name('personalis_bsm_2');
    Route::post('/import-personalis_bsm_2',[PersonalisBsm2Controller::class,'import'])->name('personalis_bsm_2.import');
    Route::get('/personalis_bsm_2/show',[PersonalisBsm2Controller::class,'show'])->name('personalis_bsm_2.show');
    Route::get('/personalis_bsm_2/export',[PersonalisBsm2Controller::class,'export'])->name('personalis_bsm_2.export');
    Route::get('/personalis_bsm_2/delete/{id}',[PersonalisBsm2Controller::class,'delete'])->name('personalis_bsm_2.delete');
});



