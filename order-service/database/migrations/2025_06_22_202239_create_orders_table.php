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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('restaurants_id');
            $table->unsignedFloat('latitude');
            $table->unsignedFloat('longitude');
            $table->integer('delivery_id')->nullable();
            $table->double('sub_total')->default(0);
            $table->unsignedFloat('discount')->default(0);
            $table->unsignedFloat('delivery_service')->default(0);
            $table->unsignedFloat('total')->default(0);
            $table->unsignedFloat('tax')->default(0);
            $table->string('currency')->nullable();
            $table->enum('restaurants_status', ['pending', 'acceptance','complete', 'reject']);
            $table->enum('delivery_status', ['pending', 'acceptance','received','complete','not used','error','not found']);
            $table->enum('payment_method',['cod','card']);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
