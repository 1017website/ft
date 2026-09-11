<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_visitors', function (Blueprint $table) {
            $table->id();
            $table->date('day')->index();
            $table->string('visitor_hash', 64);
            $table->unsignedInteger('views')->default(0);
            $table->string('device', 20);
            $table->string('source', 255);
            $table->timestamps();
            $table->unique(['day', 'visitor_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_visitors');
    }
};
