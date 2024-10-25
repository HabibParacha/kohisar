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

        Schema::create('receipes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });


        Schema::create('receipe_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipe_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('quantity', 15, 4)->nullable();

            $table->foreign('receipe_id')->references('id')->on('receipes')->onDelete('cascade');


            $table->timestamps();
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
        Schema::dropIfExists('receipe_detail');
        Schema::dropIfExists('receipes');
    }
};
