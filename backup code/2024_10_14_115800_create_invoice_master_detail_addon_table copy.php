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
        Schema::disableForeignKeyConstraints();

        Schema::create('invoice_master', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('due_date');
            $table->string('invoice_no')->unique();
            $table->string('reference_no')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('biller_id')->nullable();
            $table->unsignedBigInteger('saleman_id')->nullable();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->string('serving_type_id')->nullable();
            $table->unsignedBigInteger('table_no_id')->nullable();
            $table->string('delivery_rider_name')->nullable();
            $table->string('delivery_phone')->nullable();
            $table->string('delivery_address')->nullable();
            $table->decimal('item_total', 14, 2)->nullable();
            $table->decimal('addons_total', 14, 2)->nullable();
            $table->decimal('shipping', 14, 2)->nullable();
            $table->decimal('sub_total', 14, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 14, 2)->nullable();
            $table->decimal('discount_amount', 14, 2)->nullable();
            $table->decimal('total', 14, 2)->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('grand_total', 14, 2)->nullable();

            $table->longText('description')->nullable();
            $table->string('file')->nullable();

            $table->timestamps();
            

        });
            
        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_master_id');
            $table->date('date')->nullable();
            $table->string('invoiceNo')->nullable();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->decimal('quantity',15,2)->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->decimal('item_total', 14, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 14, 2)->nullable();
            $table->decimal('discount_amount', 14, 2)->nullable();  
            $table->decimal('total_after_discount', 14, 2)->nullable();
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('total',15,2)->nullable();
            $table->timestamps();

            $table->foreign('invoice_master_id')->references('id')->on('invoice_master')->onDelete('cascade');


        });

        Schema::create('invoice_item_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_detail_id')->nullable();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->unsignedBigInteger('addon_id')->nullable();
            $table->decimal('quantity',15,2)->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->timestamps();

            $table->foreign('invoice_detail_id')->references('id')->on('invoice_detail')->onDelete('cascade');

        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_item_addons');
        Schema::dropIfExists('invoice_detail');
        Schema::dropIfExists('invoice_master');
    }
};
