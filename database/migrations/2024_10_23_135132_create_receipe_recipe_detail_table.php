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

        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
         
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('total_quantity',15,4)->nullable();
            $table->boolean('is_active')->default(1);
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });


        Schema::create('recipe_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('quantity', 15, 4)->nullable();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');


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
        Schema::dropIfExists('recipe_detail');
        Schema::dropIfExists('recipes');
    }
};
