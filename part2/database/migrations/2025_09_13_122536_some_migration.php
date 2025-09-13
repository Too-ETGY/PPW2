<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('some_table', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->string('Decription')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('some_table');
    }
};
