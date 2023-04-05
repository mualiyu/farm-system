<?php

use App\Http\Controllers\ActuatorController;
use Illuminate\Support\Facades\Auth;
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

$controller_path = 'App\Http\Controllers';

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Main Page Route
Route::get('/account-settings', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::get('/actuators', [ActuatorController::class, 'index'])->name('actuators');
Route::get('/actuator/{actuator}', [ActuatorController::class, "show"])->name("actuator");
Route::post('/actuators', [ActuatorController::class, "store"])->name('store_actuator');
Route::post('/actuator/{actuator}/nodes', [ActuatorController::class, "store_node"])->name('store_node');
Route::post('/actuator/{actuator}/reset', [ActuatorController::class, "reset"])->name('reset_actuator');
Route::post('/actuator/{node}/node/delete', [ActuatorController::class, "delete_node"])->name('delete_node');
Route::post('/actuator/{node}/node/update', [ActuatorController::class, "update_node"])->name('update_node');

Route::get('/actuators/get_mode', [ActuatorController::class, 'get_mode'])->name('get_mode');

Route::get('/actuator/uppdate/node/details', [SensorDetailController::class, "update_details"]);