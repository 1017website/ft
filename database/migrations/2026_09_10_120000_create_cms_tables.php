<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
        Schema::create('site_sections', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->json('content');
            $table->timestamps();
        });
        Schema::create('quotation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('contact');
            $table->string('email');
            $table->string('phone');
            $table->string('pickup');
            $table->string('destination');
            $table->string('fleet');
            $table->string('weight')->nullable();
            $table->text('details')->nullable();
            $table->string('status')->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_requests');
        Schema::dropIfExists('site_sections');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('is_admin'));
    }
};
