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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->enum('stock_status', ['instock', 'outofstock', 'reorder'])->default('instock');
            $table->unsignedInteger('reorder_quantity')->default(0);
            $table->unsignedInteger('outofstock_quantity')->default(0);
            $table->boolean('featured')->default(false);
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->enum('sex', ['male', 'female', 'all'])->default('all');
            $table->boolean('low_stock_notified')->default(false);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
