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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->char('base_unit',50)->nullable();
            $table->char('child_unit',50)->nullable();
            $table->decimal('base_unit_value',10,2)->unsigned()->nullable();
            $table->char('operator',1)->nullable();
            $table->decimal('child_unit_value',10,2)->unsigned()->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => UnitSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
