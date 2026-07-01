<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('kategori'); // personal, freelance, industri
            $table->string('gambar')->nullable(); // file path
            $table->string('url_demo')->nullable();
            $table->string('url_repository')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('catatan_admin')->nullable();
            $table->integer('poin')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
