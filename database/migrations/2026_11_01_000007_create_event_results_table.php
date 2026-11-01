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
        Schema::create('event_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('category')->nullable();
            $table->unsignedTinyInteger('position');
            $table->string('participant_name');
            $table->foreignId('state_association_id')->nullable()->constrained()->nullOnDelete();
            $table->string('score')->nullable();
            $table->string('remarks')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->index(['event_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_results');
    }
};
