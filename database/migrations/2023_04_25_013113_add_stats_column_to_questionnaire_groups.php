<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questionnaire_groups', function (Blueprint $table) {
            $table->longText('stats')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire_groups', function (Blueprint $table) {
            $table->dropColumn('stats');
        });
    }
};
