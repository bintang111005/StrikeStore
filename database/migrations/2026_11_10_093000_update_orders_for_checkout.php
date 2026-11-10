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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        if (! Schema::hasColumn('order_items', 'variant')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->string('variant', 100)->nullable()->after('product_name');
            });
        }

        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('order_items', 'variant')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('variant');
            });
        }
    }
};
