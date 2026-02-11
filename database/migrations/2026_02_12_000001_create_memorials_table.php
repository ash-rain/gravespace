<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memorials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('maiden_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('place_of_death')->nullable();
            $table->longText('obituary')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('profile_photo')->nullable();
            $table->enum('privacy', ['public', 'password', 'invite_only'])->default('public');
            $table->string('password_hash')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('cemetery_name')->nullable();
            $table->string('cemetery_address')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memorials');
    }
};
