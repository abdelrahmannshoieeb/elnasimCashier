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
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade')->onUpdate('cascade');
            $table->double('total', 15, 2);
            $table->double('payedAmount', 15, 2);
            $table->text('notes')->nullable();
            $table->double('discount', 15, 2)->default(0);
            $table->double('still', 15, 2)->default(0);
            $table->enum('status', ['unpaid', 'paid', 'partiallyPaid', 'cancelled']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};
