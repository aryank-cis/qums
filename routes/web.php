<?php

use Illuminate\Support\Facades\Route;
use  Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\{DepartmentsController};
use App\Http\Controllers\{HomeController, QueryController};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view("auth.login");
});


Auth::routes();
Route::middleware('auth')->group(function () {
	Route::get('/querySubmission', [HomeController::class, 'querySubmission'])->name('querySubmission');
	Route::post('/QueryMember', [HomeController::class, 'searchSubmission'])->name('QueryMember');
	Route::post('/users/submitQuery', [HomeController::class, 'queryFormSubmission'])->name('submitQuery');
	Route::get('/home', [HomeController::class, 'index'])->name('home');
	Route::get('/admin/departments', [DepartmentsController::class, 'index'])->name('departments');
	Route::get('/toQueries', [QueryController::class, 'toQueries'])->name('toQueries');
	Route::get('Query', [QueryController::class, 'index'])->name('Query');
	Route::get('QueryRemove/{id}', [QueryController::class, 'QueryRemove'])->name('QueryRemove');
	Route::get('queryShow/{id}', [QueryController::class, 'queryShow'])->name('queryShow');
	Route::post('queryAction', [QueryController::class, 'QueryAction'])->name('queryAction');
	Route::post('QueryUserAction', [QueryController::class, 'QueryUserAction'])->name('QueryUserAction');
	Route::get('/ShowQueryList', [QueryController::class, 'ShowQueryList'])->name('ShowQueryList');
});
