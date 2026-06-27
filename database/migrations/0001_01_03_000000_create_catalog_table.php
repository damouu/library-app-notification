<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chapter_projection', function (Blueprint $table) {
            $table->id();
            $table->uuid('chapter_uuid')->unique()->index();
            $table->uuid('series_uuid')->index();
            $table->string('title');
            $table->string('second_title')->nullable();
            $table->unsignedInteger('total_pages');
            $table->unsignedInteger('chapter_number');
            $table->text('summary')->nullable();
            $table->string('cover_artwork_url');
            $table->date('publication_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapter_projection');
    }
};
