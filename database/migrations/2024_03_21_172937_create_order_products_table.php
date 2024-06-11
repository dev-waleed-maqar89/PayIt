<?php

use App\Models\order;
use App\Models\OrderProduct;
use App\Models\Product;
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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(order::class)
                ->constrained()
                ->cascadeOnDelete('cascade')
                ->cascadeOnUpdate();
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete('cascade')
                ->cascadeOnUpdate();
            $table->timestamps();
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};