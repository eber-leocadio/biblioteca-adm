<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'isbn',
        'descricao',
        'ano_publicacao',
        'editora',
        'numero_paginas',
        'quantidade_total',
        'quantidade_disponivel',
        'localizacao',
        'author_id',
        'category_id',
        'status'
    ];

    protected $casts = [
        'ano_publicacao' => 'integer',
        'numero_paginas' => 'integer',
        'quantidade_total' => 'integer',
        'quantidade_disponivel' => 'integer',
    ];

    /**
     * Relacionamento com autor
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Relacionamento com categoria
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relacionamento com empréstimos
     */
    public function emprestimos()
    {
        return $this->hasMany(Emprestimos::class);
    }

    /**
     * Verifica se o livro está disponível para empréstimo
     */
    public function isDisponivel()
    {
        return $this->quantidade_disponivel > 0 && $this->status === 'disponivel';
    }

    /**
     * Diminui a quantidade disponível
     */
    public function emprestar()
    {
        if ($this->quantidade_disponivel > 0) {
            $this->decrement('quantidade_disponivel');
        }
    }

    /**
     * Aumenta a quantidade disponível
     */
    public function devolver()
    {
        if ($this->quantidade_disponivel < $this->quantidade_total) {
            $this->increment('quantidade_disponivel');
        }
    }
}
