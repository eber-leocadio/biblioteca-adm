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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->date('data_emprestimo');
            $table->date('data_prevista_devolucao');
            $table->date('data_devolucao')->nullable();
            $table->enum('status', ['ativo', 'devolvido', 'atrasado', 'perdido'])->default('ativo');
            $table->text('observacoes')->nullable();
            $table->decimal('multa', 8, 2)->default(0);
            $table->timestamps();
            
            // Índices para melhor performance
            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index('data_prevista_devolucao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
