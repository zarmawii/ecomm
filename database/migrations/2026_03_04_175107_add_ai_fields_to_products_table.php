<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('ai_status')->default('pending');
            $table->string('admin_status')->default('pending');
            $table->string('ai_result')->nullable();
            $table->float('ai_confidence')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'ai_status',
                'admin_status',
                'ai_result',
                'ai_confidence'
            ]);
        });
    }
};