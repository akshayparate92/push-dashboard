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
        Schema::table('single_pushes', function (Blueprint $table) {
            $table->enum('optimize_type', ['same_time', 'intelligent'])->nullable()->after('push_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('single_pushes', function (Blueprint $table) {
            $table->dropColumn('optimize_type');
        });
    }
};
