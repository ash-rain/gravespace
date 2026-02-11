<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_memorial_id')->constrained('memorials')->cascadeOnDelete();
            $table->enum('relationship', ['parent', 'child', 'sibling', 'spouse', 'grandparent', 'grandchild', 'other']);
            $table->timestamps();
            $table->unique(['memorial_id', 'related_memorial_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_links');
    }
};
