<?php

use App\Http\Controllers\Accounts;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaxController;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalemanDashboard;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\AccountReportsController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\OpeningBalanceController;
use App\Http\Controllers\PartyWarehouseController;
use App\Http\Controllers\RolePermissionsController;
use App\Http\Controllers\FinishedGoodsStockController;


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
})->middleware(['auth', 'verified',])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/refresh-session', [SessionController::class, 'refreshSession']);
    Route::post('/logout', [SessionController::class, 'logout']);

    Route::resource('customer', CustomerController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('tax', TaxController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('unit', UnitController::class);


    Route::get('items/get-all', [ItemController::class, 'getAllItems'])->name('items.getAll');
    Route::resource('item', ItemController::class);

    Route::get('recipe/create-version/{id}', [RecipeController::class, 'createVersion'])->name('recipe.createVersion');
    Route::get('/recipes/{id}/detail-with-stock', [RecipeController::class, 'getRecipeDetailWithStock'])->name('getRecipeDetailWithStock');
    Route::resource('recipe', RecipeController::class);

    Route::resource('purchase-order', PurchaseOrderController::class);
    Route::get('purchase-order/test/create', [PurchaseOrderController::class,'createTest'])->name('purcahse-order.createTest');//********************** */

    
    Route::resource('sale-order', SaleOrderController::class);

    Route::get('sale-order/{id}/create-sale-invoice', [SaleInvoiceController::class, 'createFromSaleOrder'])->name('sale-invoice.createFromSaleOrder');
    Route::resource('sale-invoice', SaleInvoiceController::class);

    Route::get('production/posting/{id}', [ProductionController::class, 'posting'])->name('production.posting');
    Route::get('production/unposting/{id}', [ProductionController::class, 'unposting'])->name('production.unposting');
    Route::resource('production', ProductionController::class);

    Route::resource('expense', ExpenseController::class);


    Route::get('chart-of-account/get-by-category/{id}', [ChartOfAccountController::class, 'getByCategory'])->name('chart-of-account.getByCategory');
    Route::resource('chart-of-account', ChartOfAccountController::class);


    Route::get('balance-sheet/request', [BalanceSheetController::class, 'request'])->name('balance-sheet.request');
    Route::post('balance-sheet/show', [BalanceSheetController::class, 'show'])->name('balance-sheet.show');

   

    


   


    Route::get('party-index/{type?}', [PartyController::class, 'index'])->name('party-index');
    Route::resource('party', PartyController::class);
    
    Route::get('party-warehouse/fetch-list/{party_id}', [PartyWarehouseController::class, 'fetchList'])->name('party-warehouse.fetchList');
    Route::resource('party-warehouse', PartyWarehouseController::class);
    
    
    
    Route::get('user/download-sample-file', [UserController::class, 'downloadSampleFile'])->name('user.downloadSampleFile');
    Route::post('user/upload-file', [UserController::class, 'uploadFile'])->name('user.uploadFile');
    Route::resource('user', UserController::class);
    
    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
    Route::get('/saleman-dashboard', SalemanDashboard::class)->name('saleman-dashboard');



    Route::get('voucher/create-jv', [VoucherController::class, 'createJournalVoucher'])->name('voucher.createJournalVoucher');
    Route::post('voucher/store-jv', [VoucherController::class, 'storeJournalVoucher'])->name('voucher.storeJournalVoucher');
    Route::resource('voucher', VoucherController::class);

    Route::resource('finished-goods-stock', FinishedGoodsStockController::class);


    // START::Account Section 
    

    Route::get('account-reports/request', [AccountReportsController::class, 'request'])->name('account-reports.request');
    Route::post('account-reports/voucher-pdf', [AccountReportsController::class, 'voucherPDF'])->name('account-reports.voucherPDF');
    Route::post('account-reports/cashbook-pdf', [AccountReportsController::class, 'cashbookPDF'])->name('account-reports.cashbookPDF');
    Route::post('account-reports/gernal-ledger-pdf', [AccountReportsController::class, 'gernalLedgerPDF'])->name('account-reports.gernalLedgerPDF');
    Route::post('account-reports/daybook-pdf', [AccountReportsController::class, 'daybookPDF'])->name('account-reports.daybookPDF');
    Route::post('account-reports/trial-balance-pdf', [AccountReportsController::class, 'trialBalancePDF'])->name('account-reports.trialBalancePDF');
    Route::post('account-reports/customer-balance-pdf', [AccountReportsController::class, 'customerBalancePDF'])->name('account-reports.customerBalancePDF');
    Route::post('account-reports/supplier-balance-pdf', [AccountReportsController::class, 'supplierBalancePDF'])->name('account-reports.supplierBalancePDF');
    Route::post('account-reports/expense-pdf', [AccountReportsController::class, 'expensePDF'])->name('account-reports.expensePDF');
    Route::post('account-reports/customer-ledger-pdf', [AccountReportsController::class, 'customerLedgerPDF'])->name('account-reports.customerLedgerPDF');
    Route::post('account-reports/supplier-ledger-pdf', [AccountReportsController::class, 'supplierLedgerPDF'])->name('account-reports.supplierLedgerPDF');
    Route::post('account-reports/balance-sheet-pdf', [AccountReportsController::class, 'balanceSheetPDF'])->name('account-reports.balanceSheetPDF');
    
    
    // START::Report Section 
    Route::get('report/raw-material-stock',[ReportController::class,'fetchRawMaterailStock'])->name('report.fetchRawMaterailStock');    
    Route::get('report/finished-goods-stock',[ReportController::class,'fetchFinishedGoodsStock'])->name('report.fetchFinishedGoodsStock');    
    
    Route::get('report/production/request', [ReportController::class, 'productionRequest'])->name('report.production.request');
    Route::post('report/production/show', [ReportController::class, 'productionShow'])->name('report.production.show');


    Route::get('report/raw-material-history/request', [ReportController::class, 'rawMaterialHistoryRequest'])->name('report.raw-material-history.request');
    Route::post('report/raw-material-history/show', [ReportController::class, 'rawMaterialHistroyShow'])->name('report.raw-material-history.show');
    
    Route::get('report/material-received-history/request', [ReportController::class, 'materialReceivedHistoryRequest'])->name('report.material-received-history.request');
    Route::post('report/material-received-history/show', [ReportController::class, 'materialReceivedHistoryshow'])->name('report.material-received-history.show');
    
    Route::get('report/raw-material-stock-level/request', [ReportController::class, 'rawMaterialStockLevelRequest'])->name('report.raw-material-stock-level.request');
    Route::post('report/raw-material-stock-level/show', [ReportController::class, 'rawMaterialStockLevelShow'])->name('report.raw-material-stock-level.show');
    // User Permissions
    Route::get('role-permissions/ajax', [RolePermissionsController::class, 'ajax'])->name('role-permissions.ajax');
    Route::resource('role-permissions', RolePermissionsController::class);


});

Route::post('test',[TestController::class, 'test']);







Route::redirect('URI', 'URI', 301);
require __DIR__.'/auth.php';
