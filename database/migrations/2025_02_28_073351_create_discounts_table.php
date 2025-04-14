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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama promo
            $table->string('promo_code')->unique(); // Kode unik (misal: NEWYEAR2025)
            $table->enum('type', ['global', 'event'])->default('global'); // Jenis promo
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed'); // Jenis diskon
            $table->decimal('discount_amount', 15, 2); // Nilai diskon
            $table->dateTime('start_date')->nullable(); // Tanggal mulai
            $table->dateTime('end_date')->nullable(); // Tanggal akhir
            $table->enum('status', ['Draft', 'Public'])->default('Public'); // Status promo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
