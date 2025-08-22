<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Make the category_id column nullable first
            $table->unsignedBigInteger('category_id')->nullable()->change();

            // Drop the existing foreign key constraint
            $table->dropForeign(['category_id']);

            // Add the new foreign key constraint with onDelete('set null')
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the 'set null' foreign key
            $table->dropForeign(['category_id']);

            // Re-add the original foreign key constraint (assuming onDelete('cascade') was the default)
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

            // Make the column not nullable again
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }
};
