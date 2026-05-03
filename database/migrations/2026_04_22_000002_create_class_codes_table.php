<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_codes', function (Blueprint $table) {
            $table->id();
            $table->string('program');
            $table->string('code');
            $table->integer('duration_minutes')->default(90);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_codes');
    }
};
