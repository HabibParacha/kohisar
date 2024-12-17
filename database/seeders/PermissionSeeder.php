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
 
        $sections = [
            'User' => 'user',
            'User Permissions' => 'role-permissions',
            'Category' => 'category',
            'Tax' => 'tax',
            'Unit' => 'unit',
            'Party' => 'party',
            'Item' => 'item',
            'Recipe' => 'recipe',
            'Bill Receipt' => 'bill-receipt',
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


        $additionalPermissions = [
            ['section' => 'Reports', 'action' => 'Cashbook', 'route_name' => 'account-reports.cashbookPDF'],
            ['section' => 'Reports', 'action' => 'General Ledger', 'route_name' => 'account-reports.generalLedgerPDF'],
            ['section' => 'Reports', 'action' => 'Daybook', 'route_name' => 'account-reports.daybookPDF'],
            ['section' => 'Reports', 'action' => 'Trail Balance', 'route_name' => 'account-reports.trialBalancePDF'],
            ['section' => 'Reports', 'action' => 'Customer Balance', 'route_name' => 'account-reports.customerBalancePDF'],
            ['section' => 'Reports', 'action' => 'Supplier Balance', 'route_name' => 'account-reports.supplierBalancePDF'],
            ['section' => 'Reports', 'action' => 'Expense', 'route_name' => 'account-reports.expensePDF'],
            ['section' => 'Reports', 'action' => 'Customer Ledger', 'route_name' => 'account-reports.customerLedgerPDF'],
            ['section' => 'Reports', 'action' => 'Supplier Ledger', 'route_name' => 'account-reports.supplierLedgerPDF'],
            ['section' => 'Reports', 'action' => 'Raw Material Stock', 'route_name' => 'reports.fetchRawMaterailStock'],
            ['section' => 'Reports', 'action' => 'Finished Goods Stock', 'route_name' => 'reports.fetchFinishedGoodsStock'],
        ];

        
        
        $permissions = array_merge($permissions, $additionalPermissions);


        DB::table('permissions')->insert($permissions);
    }
    
}
