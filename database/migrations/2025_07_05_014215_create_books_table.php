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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('isbn')->unique()->nullable();
            $table->text('descricao')->nullable();
            $table->integer('ano_publicacao')->nullable();
            $table->string('editora')->nullable();
            $table->integer('numero_paginas')->nullable();
            $table->integer('quantidade_total')->default(1);
            $table->integer('quantidade_disponivel')->default(1);
            $table->string('localizacao')->nullable(); // Estante/Seção
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['disponivel', 'indisponivel', 'manutencao'])->default('disponivel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
