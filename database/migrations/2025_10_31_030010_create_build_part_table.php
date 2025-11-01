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
        Schema::create('build_part', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pcbuild_id')->constrained('pcbuilds')->onDelete('cascade');
            $table->foreignId('part_id')->constrained('parts')->onDelete('cascade');
            $table->decimal('custom_price', 10, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_part');
    }
};
