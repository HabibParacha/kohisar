<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WarehouseController;


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
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   

    Route::resource('customer', CustomerController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('tax', TaxController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('product', ProductController::class);
    Route::resource('item', ItemController::class);

    Route::get('party/{type?}', [PartyController::class, 'index'])->name('party-index');
    Route::resource('party', PartyController::class);
    
    
    
    
    
    Route::get('user/download-sample-file', [UserController::class, 'downloadSampleFile'])->name('user.downloadSampleFile');
    Route::post('user/upload-file', [UserController::class, 'uploadFile'])->name('user.uploadFile');
    Route::resource('user', UserController::class);
    
    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
    // Route::get('/driver-dashboard', DriverDashboard::class)->name('driver-dashboard');
    
    
  
});






Route::redirect('URI', 'URI', 301);
require __DIR__.'/auth.php';
