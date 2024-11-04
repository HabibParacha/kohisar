<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->decimal('sell_price', 20, 2)->nullable();
            $table->decimal('purchase_price', 20, 2)->nullable();
            $table->decimal('stock_alert_qty', 20, 2)->nullable();
            $table->decimal('unit_weight', 20, 2)->nullable();
            
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            
            $table->unsignedBigInteger('sell_cart_of_account_id')->nullable();
            $table->unsignedBigInteger('purchase_cart_of_account_id')->nullable();

            $table->boolean('is_active')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
