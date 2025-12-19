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
        Schema::create('children', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->char('family_id', 26);
            $table->string('child_name', 100);
            $table->string('child_birth_place', 100);
            $table->date('child_birth_date');
            $table->enum('child_gender', ['laki-laki', 'perempuan'])->nullable();
            $table->binary('child_address', 500);
            $table->string('child_complaint', 200);
            $table->string('child_school', 100)->nullable();
            $table->string('child_service_choice', 250);
            $table->enum('child_religion', ['islam','kristen','katolik','hindu','budha','konghucu','lainnya'])->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->index('family_id');
            $table->index('child_name');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
