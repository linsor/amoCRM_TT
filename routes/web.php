<?php

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\API\CreateLeadsController;
use App\Http\Controllers\API\EditLeadController;
use App\Http\Controllers\API\IndexLeadsController;
use App\Http\Controllers\API\ShowLeadController;
use App\Http\Controllers\API\StoreLeadController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\UdpateLeadController;
use App\Http\Controllers\API\UpdateLeadController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelIgnition\Http\Controllers\UpdateConfigController;

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
    return view('welcome');
});

Route::patch('/lead/{lead}', [UpdateLeadController::class, '__invoke'])->name('lead.update');
Route::get('/leads', [IndexLeadsController::class, '__invoke'])->name('lead.index');
Route::get('/{lead}/edit', [EditLeadController::class,'__invoke'])->name('lead.edit');

Route::post('/lead', [StoreLeadController::class, '__invoke'])->name('lead.store');
Route::get('/create', [CreateLeadsController::class, '__invoke'])->name('lead.create');
Route::get('/{lead}', [ShowLeadController::class, '__invoke'])->name('lead.show');



