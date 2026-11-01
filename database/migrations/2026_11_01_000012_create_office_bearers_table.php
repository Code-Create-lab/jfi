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
        Schema::create('office_bearers', function (Blueprint $table) {
            $table->id();
            $table->string('level', 20)->index();
            $table->foreignId('state_association_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('designation');
            $table->string('photo')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_bearers');
    }
};
