<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the location column for databases that ran the original
 * create_office_bearers_table migration before location was introduced.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('office_bearers', 'location')) {
            return;
        }

        Schema::table('office_bearers', function (Blueprint $table) {
            $table->string('location')->nullable()->after('designation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The column belongs to the create migration on fresh installs, so it is left in place.
    }
};
