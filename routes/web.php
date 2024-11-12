<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\PartyWarehouseController;


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
    Route::resource('production', ProductionController::class);
    Route::resource('expense', ExpenseController::class);

   
    Route::resource('sale-order', SaleOrderController::class);

    Route::get('chart-of-account/get-by-category/{id}', [ChartOfAccountController::class, 'getByCategory'])->name('chart-of-account.getByCategory');
    Route::resource('chart-of-account', ChartOfAccountController::class);

    // create1 name because create was resource controller function and create do mot accept $id parameter 
    Route::get('sale-order/{id}/create-sale-invoice', [SaleInvoiceController::class, 'createFromSaleOrder'])->name('sale-invoice.createFromSaleOrder');
    Route::resource('sale-invoice', SaleInvoiceController::class);

    Route::get('items/get-all', [ItemController::class, 'getAllItems'])->name('items.getAll');
    Route::resource('item', ItemController::class);
    Route::resource('purchase-order', PurchaseOrderController::class);


    Route::get('/recipes/{id}/detail-with-stock', [RecipeController::class, 'getRecipeDetailWithStock'])->name('getRecipeDetailWithStock');
    Route::resource('recipe', RecipeController::class);


    Route::get('party-index/{type?}', [PartyController::class, 'index'])->name('party-index');
    Route::resource('party', PartyController::class);
    
    Route::get('party-warehouse/fetch-list/{party_id}', [PartyWarehouseController::class, 'fetchList'])->name('party-warehouse.fetchList');
    Route::resource('party-warehouse', PartyWarehouseController::class);
    
    
    
    Route::get('user/download-sample-file', [UserController::class, 'downloadSampleFile'])->name('user.downloadSampleFile');
    Route::post('user/upload-file', [UserController::class, 'uploadFile'])->name('user.uploadFile');
    Route::resource('user', UserController::class);
    
    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
    // Route::get('/driver-dashboard', DriverDashboard::class)->name('driver-dashboard');



    Route::resource('voucher', VoucherController::class);
    
    
  
});






Route::redirect('URI', 'URI', 301);
require __DIR__.'/auth.php';
