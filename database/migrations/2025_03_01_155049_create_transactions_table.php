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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Link sa online user (optional)
            $table->foreignId('loyalty_id')->constrained('user_loyalty_points')->onDelete('cascade'); // RFID-based transactions
            $table->integer('points'); // Ilang points ang nakuha o ginamit
            $table->enum('type', ['earn', 'redeem']); // Kung ito ba ay earning o redemption
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
