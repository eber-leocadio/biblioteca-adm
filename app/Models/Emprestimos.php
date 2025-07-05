<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Emprestimos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'data_emprestimo',
        'data_prevista_devolucao',
        'data_devolucao',
        'status',
        'observacoes',
        'multa'
    ];

    protected $casts = [
        'data_emprestimo' => 'date',
        'data_prevista_devolucao' => 'date',
        'data_devolucao' => 'date',
        'multa' => 'decimal:2',
    ];

    /**
     * Relacionamento com usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com livro
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Verifica se o empréstimo está atrasado
     */
    public function isAtrasado()
    {
        return $this->status === 'ativo' && 
               $this->data_prevista_devolucao->isPast();
    }

    /**
     * Calcula dias de atraso
     */
    public function diasAtraso()
    {
        if (!$this->isAtrasado()) {
            return 0;
        }

        return $this->data_prevista_devolucao->diffInDays(now());
    }

    /**
     * Calcula multa baseada nos dias de atraso
     */
    public function calcularMulta($valorDiario = 2.00)
    {
        return $this->diasAtraso() * $valorDiario;
    }

    /**
     * Finaliza o empréstimo
     */
    public function devolver()
    {
        $this->update([
            'data_devolucao' => now(),
            'status' => 'devolvido',
            'multa' => $this->isAtrasado() ? $this->calcularMulta() : 0
        ]);

        // Atualiza a quantidade disponível do livro
        $this->book->devolver();
    }

    /**
     * Scope para empréstimos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para empréstimos atrasados
     */
    public function scopeAtrasados($query)
    {
        return $query->where('status', 'ativo')
                    ->where('data_prevista_devolucao', '<', now());
    }
}
