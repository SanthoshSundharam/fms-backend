<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();

            // Foreign key to users
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade'); // delete farmers if user is deleted

            $table->string('name');
            $table->string('village_name');
            $table->string('mobile_number');

            $table->string('bank_account');
            $table->string('ifsc_code');
            $table->string('bank_name');
            $table->string('branch');

            $table->string('aadhar_number')->nullable();

            // Optional farmer image
            $table->string('farmer_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
