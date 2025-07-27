<?php

use App\Models\Game;
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
        Schema::create('recurring_pushes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Game::class)->nullable()->default(null)->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['failed', 'created','scheduled', 'stopped'])->nullable();
            $table->timestamp('scheduled_time')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->enum('frequency',['daily','weekly','monthly']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_pushes');
    }
};
