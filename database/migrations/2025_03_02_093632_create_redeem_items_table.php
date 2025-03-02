<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('redeem_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User na nag-redeem
            $table->foreignId('loyalty_id')->constrained('user_loyalty_points')->onDelete('cascade'); // Points record
            $table->integer('points_used'); // Ilang points ang ginamit
            $table->foreignId('reward_id')->nullable()->constrained('products')->onDelete('set null'); // Reward (optional)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status ng redemption
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('redeem_items');
    }
};

