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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->text('narration')->nullable();


            $table->unsignedBigInteger('party_id')->nullable()->comment('Used when a client is both a customer and supplier. Represents the party entity.');;
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();



            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('invoice_master_id')->nullable();
            $table->unsignedBigInteger('production_id')->nullable();
            $table->unsignedBigInteger('expense_id')->nullable();

            $table->decimal('debit', 20,2)->nullable();
            $table->decimal('credit', 20,2)->nullable();

            $table->string('trace')->nullable();


            $table->unsignedBigInteger('created_by')->nullable();// ID of the user who created the record
            $table->unsignedBigInteger('updated_by')->nullable();// ID of the user who last updated the record

            $table->timestamps();

            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
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
        Schema::dropIfExists('journals');
    }
};
