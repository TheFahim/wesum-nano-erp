<?php

use App\Models\PublicationArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {

            $table->id();
            $table->foreignIdFor(PublicationArea::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('title');
            $table->string('link')->nullable();
            $table->year('year');
            $table->json('authors');
            $table->string('cover_image')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
