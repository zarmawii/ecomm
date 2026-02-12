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
    Schema::table('sellers', function (Blueprint $table) {
       $table->string('state')->nullable();
        $table->string('district')->nullable();
        $table->string('village')->nullable();
        $table->string('pincode')->nullable();
    });
}

public function down(): void
{
    Schema::table('sellers', function (Blueprint $table) {
        $table->dropColumn(['state', 'district', 'village', 'pincode']);
    });
}

};
