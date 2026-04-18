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
        Schema::create('user_challenges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('health_challenge_id');
            $table->date('challenge_date');
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->integer('streak')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('health_challenge_id')->references('id')->on('health_challenges')->onDelete('cascade');
            $table->unique(['user_id', 'health_challenge_id', 'challenge_date'], 'uc_user_challenge_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_challenges');
    }
};
