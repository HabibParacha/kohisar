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
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_code')->unique();  // Standardized code (e.g., 1000, 1110)
            $table->string('account_name');            // Account name (e.g., "Petty Cash")
            $table->string('description')->nullable(); // Optional description
            $table->integer('level');                  // Account level (e.g., 1, 2, 3, or 4)
            $table->unsignedBigInteger('parent_id')->nullable(); // Reference to parent account
            $table->enum('type', ['asset', 'liability', 'equity', 'revenue', 'expense']); // Account type
            $table->string('category')->nullable();
            $table->boolean('is_lock')->default(1);
            $table->boolean('is_active')->default(1);

            $table->foreign('parent_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $table->timestamps();
            
        });
        Artisan::call('db:seed', [
            '--class' => ChartOfAccountSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
