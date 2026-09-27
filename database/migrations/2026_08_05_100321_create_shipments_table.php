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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('waybill_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rider_id')->nullable()->constrained()->nullOnDelete();

            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('pickup_address');

            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('delivery_address');

            $table->string('package_type')->default('Parcel');
            $table->decimal('weight_kg', 8, 2)->default(1);
            $table->text('description')->nullable();
            $table->string('destination_zone')->default('within_kano');

            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->enum('payment_method', ['pay_on_delivery', 'online'])->default('pay_on_delivery');

            $table->enum('status', ['pending', 'picked_up', 'in_transit', 'out_for_delivery', 'delivered', 'cancelled'])->default('pending');

            $table->string('qr_code_path')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
