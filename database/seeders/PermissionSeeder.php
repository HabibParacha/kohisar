<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //  'User Permissions' => 'role-permissions',

        $sections = [
            'User' => 'user',
            'Category' => 'category',
            'Brand' => 'brand',
            'Tax' => 'tax',
            'Unit' => 'unit',
            'Party' => 'party',
            'Item' => 'item',
            'Recipe' => 'recipe',
            'Bill Receipt' => 'bill-receipt',//purchase order
            'Sale Order' => 'sale-order',
            'Sale Invoice' => 'sale-invoice',
            'Production' => 'production',
            'Expense' => 'expense',
            'Voucher' => 'voucher',
        ];

        $actions = [
            'List' => 'index',
            'Create' => 'create',
            'Update' => 'edit',
            'View' => 'show',
            'Delete' => 'delete',
        ];

        $permissions = [];

        foreach ($sections as $section => $routePrefix) {
            foreach ($actions as $action => $routeSuffix) {
                $permissions[] = [
                    'section' => $section,
                    'action' => $action,
                    'route_name' => "{$routePrefix}.{$routeSuffix}"
                ];
            }
        }

        

        $accountReports = [
            ['section' => 'Account Reports', 'action' => 'Request', 'route_name' => 'account-reports.request'],
            ['section' => 'Account Reports', 'action' => 'Voucher PDF', 'route_name' => 'account-reports.voucherPDF'],
            ['section' => 'Account Reports', 'action' => 'Cashbook PDF', 'route_name' => 'account-reports.cashbookPDF'],
            ['section' => 'Account Reports', 'action' => 'General Ledger PDF', 'route_name' => 'account-reports.generalLedgerPDF'],
            ['section' => 'Account Reports', 'action' => 'Daybook PDF', 'route_name' => 'account-reports.daybookPDF'],
            ['section' => 'Account Reports', 'action' => 'Trial Balance PDF', 'route_name' => 'account-reports.trialBalancePDF'],
            ['section' => 'Account Reports', 'action' => 'Customer Balance PDF', 'route_name' => 'account-reports.customerBalancePDF'],
            ['section' => 'Account Reports', 'action' => 'Supplier Balance PDF', 'route_name' => 'account-reports.supplierBalancePDF'],
            ['section' => 'Account Reports', 'action' => 'Expense PDF', 'route_name' => 'account-reports.expensePDF'],
            ['section' => 'Account Reports', 'action' => 'Customer Ledger PDF', 'route_name' => 'account-reports.customerLedgerPDF'],
            ['section' => 'Account Reports', 'action' => 'Supplier Ledger PDF', 'route_name' => 'account-reports.supplierLedgerPDF'],
            ['section' => 'Account Reports', 'action' => 'Balance Sheet PDF', 'route_name' => 'account-reports.balanceSheetPDF'],
        ];

        
        $inventoryReports = [
            ['section' => 'Inventory Reports', 'action' => 'Finished Goods Stock', 'route_name' => 'report.fetchFinishedGoodsStock'],
            ['section' => 'Inventory Reports', 'action' => 'Production Report', 'route_name' => 'report.production.request'],
            // ['section' => 'Inventory Reports', 'action' => 'Production Show', 'route_name' => 'report.production.show'],
            ['section' => 'Inventory Reports', 'action' => 'Raw Material History', 'route_name' => 'report.raw-material-history.request'],
            // ['section' => 'Inventory Reports', 'action' => 'Raw Material History Show', 'route_name' => 'report.raw-material-history.show'],
            ['section' => 'Inventory Reports', 'action' => 'Material Received History', 'route_name' => 'report.material-received-history.request'],
            // ['section' => 'Inventory Reports', 'action' => 'Material Received History Show', 'route_name' => 'report.material-received-history.show'],
            ['section' => 'Inventory Reports', 'action' => 'Raw Material Stock Level', 'route_name' => 'report.raw-material-stock-level.request'],
            // ['section' => 'Inventory Reports', 'action' => 'Raw Material Stock Level Show', 'route_name' => 'report.raw-material-stock-level.show'],
            ['section' => 'Inventory Reports', 'action' => 'Average Costing Item History', 'route_name' => 'average-costing.itemHistoryRequest'],
            // ['section' => 'Inventory Reports', 'action' => 'Average Costing Item History Show', 'route_name' => 'average-costing.itemHistoryShow'],
            ['section' => 'Inventory Reports', 'action' => 'Average Costing Items List', 'route_name' => 'average-costing.itemsListRequest'],
            // ['section' => 'Inventory Reports', 'action' => 'Average Costing Items List Show', 'route_name' => 'average-costing.itemsListShow'],
        ];
        
        
        $permissions = array_merge($permissions, $accountReports, $inventoryReports);


        DB::table('permissions')->insert($permissions);
    }
    
}
