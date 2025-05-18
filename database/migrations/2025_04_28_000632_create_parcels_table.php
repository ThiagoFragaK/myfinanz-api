<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade');
            $table->foreignId('card_id')->constrained('cards')->onDelete('cascade');
            $table->double('value', 12, 2);
            $table->integer('parcel');
            $table->date('date');
            $table->timestamps(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
