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
    Schema::create('settlements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        
        // أضف هذا السطر لربط الدين بالسكن
        $table->foreignId('colocation_id')->constrained()->onDelete('cascade'); 
        
        $table->foreignId('expense_id')->constrained()->onDelete('cascade');
        
        $table->decimal('amount', 10, 2);
        $table->enum('status', ['pending', 'paid'])->default('pending');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
