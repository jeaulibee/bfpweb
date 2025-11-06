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
    Schema::table('incidents', function (Blueprint $table) {
        $table->foreignId('citizen_id')
            ->nullable()
            ->constrained('citizens')
            ->onDelete('set null')
            ->after('reported_by'); // optional, keeps it next to reported_by
    });
}

public function down(): void
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->dropForeign(['citizen_id']);
        $table->dropColumn('citizen_id');
    });
}

};
