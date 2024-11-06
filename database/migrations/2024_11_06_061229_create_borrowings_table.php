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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->foreignUuid("book_id")->constrained()->cascadeOnDelete();
            $table->enum("status", ['PENDING','APPROVED', 'REJECTED']);
            $table->integer("total");
            $table->date("return_date");
            $table->date("return_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
