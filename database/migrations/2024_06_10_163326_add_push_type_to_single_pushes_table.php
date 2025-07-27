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
            $table->enum('push_type', ['single', 'recurring'])->default('single')->after('send_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('single_pushes', function (Blueprint $table) {
            $table->dropColumn('push_type');
        });
    }
};
