<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('dokter_id');
            $table->dateTime('jadwal');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->string('disease')->nullable();
            $table->unsignedBigInteger('dokter_id')->nullable()->change();
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dokter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}; 