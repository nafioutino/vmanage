<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('point_of_sale_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->timestamps();
            
            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['product_id', 'point_of_sale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};