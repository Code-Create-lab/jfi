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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no', 30)->nullable()->unique();
            $table->foreignId('state_association_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->date('date_of_birth');
            $table->string('gender', 20);
            $table->string('email')->unique();
            $table->string('phone', 30);
            $table->string('password');
            $table->rememberToken();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('players');
    }
};
