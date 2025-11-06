<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->string('priority')->default('medium')->after('status');
        $table->string('type')->nullable()->after('priority');
    });
}

public function down()
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->dropColumn(['priority', 'type']);
    });
}
};
