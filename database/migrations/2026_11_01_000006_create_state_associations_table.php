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
        Schema::create('state_associations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state');
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('email');
            $table->string('phone', 30);
            $table->string('president_name')->nullable();
            $table->string('secretary_name')->nullable();
            $table->string('society_registration_no')->nullable();
            $table->string('logo')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->text('admin_remarks')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_associations');
    }
};
