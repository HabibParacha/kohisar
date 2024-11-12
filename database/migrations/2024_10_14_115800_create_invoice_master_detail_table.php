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
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->string('invoice_no')->unique();
            $table->string('reference_no')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('recipe_id')->nullable();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->unsignedBigInteger('saleman_id')->nullable();// user table type saleman
            $table->unsignedBigInteger('party_warehouse_id')->nullable();
            $table->decimal('item_total', 14, 2)->nullable();
            $table->decimal('shipping', 14, 2)->nullable();
            $table->decimal('sub_total', 14, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 14, 2)->nullable();
            $table->decimal('discount_amount', 14, 2)->nullable();
            $table->decimal('total', 14, 2)->nullable();
            $table->decimal('production_material_tons', 14, 4)->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('grand_total', 14, 2)->nullable();
            $table->decimal('production_qty', 15, 2)->nullable()->comment('in kgs');
            $table->decimal('output_qty', 15, 2)->nullable()->comment('in kgs');
            $table->decimal('surplus_qty', 15, 2)->nullable()->comment('in kgs');


            $table->unsignedBigInteger('creator_id')->nullable();// who created the record

            

            $table->longText('description')->nullable();
            $table->string('attachment')->nullable();

            $table->timestamps();
            

        });
            
        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_master_id');
            $table->date('date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('type')->nullable();

            $table->unsignedBigInteger('item_id')->nullable();

            $table->decimal('unit_weight',15,2)->nullable();
            $table->decimal('gross_weight',15,2)->nullable();
            $table->decimal('cut_percentage',15,2)->nullable();
            $table->decimal('cut_value',15,2)->nullable();
            $table->decimal('after_cut_total_weight',15,2)->nullable();
            $table->decimal('total_quantity',15,2)->nullable();
            $table->decimal('per_package_weight',15,2)->nullable();
            $table->decimal('total_package_weight',15,2)->nullable();
            $table->decimal('net_weight',15,2)->nullable();
            $table->integer('is_surplus')->nullable()->default(0);

            
            $table->decimal('per_unit_price',15,2)->nullable();
            $table->decimal('per_unit_price_old_value',15,2)->nullable();// to detect change
            $table->decimal('per_unit_price_new_value',15,2)->nullable();// to detect change

            $table->decimal('total_price',15,2)->nullable();
            
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 15, 2)->nullable();
            $table->decimal('discount_amount', 15, 2)->nullable();  
            $table->decimal('after_discount_total_price', 15, 2)->nullable();  
            
            $table->decimal('tax_rate', 15, 2)->nullable();
            $table->decimal('tax_value', 15, 2)->nullable();
        
            $table->decimal('grand_total', 15, 2)->nullable();



            $table->timestamps();

            $table->foreign('invoice_master_id')->references('id')->on('invoice_master')->onDelete('cascade');


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
        Schema::dropIfExists('invoice_detail');
        Schema::dropIfExists('invoice_master');
    }
};
