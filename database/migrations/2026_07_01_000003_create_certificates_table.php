<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('penerbit')->nullable();
            $table->string('level'); // lokal, regional, nasional, internasional
            $table->date('tanggal_terbit')->nullable();
            $table->string('file_bukti')->nullable(); // file path
            $table->string('url_bukti')->nullable(); // external URL
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('catatan_admin')->nullable();
            $table->integer('poin')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
