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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('expense_no')->unique();
            $table->unsignedBigInteger('party_id')->nullable()->comment('supplier');
            
            $table->unsignedBigInteger('chart_of_account_id')->nullable()->comment('account used to pay the expense');
            $table->longText('description')->nullable();

            $table->decimal('amount_exclusive_tax', 15, 2)->nullable(); 
            $table->decimal('tax_percentage', 5, 2)->nullable();        
            $table->decimal('calculated_tax_amount', 15, 2)->nullable();
            $table->decimal('amount_inclusive_tax', 15, 2)->nullable(); 

            $table->string('attachment')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();// who created the record
            $table->timestamps();


        });



        Schema::create('expense_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->date('date')->nullable();
            $table->string('expense_no')->nullable();
            
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->longText('description')->nullable();

            $table->decimal('amount_exclusive_tax', 15, 2)->nullable(); 
            $table->decimal('tax_percentage', 5, 2)->nullable();        
            $table->decimal('calculated_tax_amount', 15, 2)->nullable();
            $table->decimal('amount_inclusive_tax', 15, 2)->nullable(); 
            
            $table->timestamps();

            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_details');
        Schema::dropIfExists('expenses');
    }
};
