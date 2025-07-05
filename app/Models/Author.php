<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        'nacionalidade',
        'data_nascimento',
        'biografia'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    /**
     * Relacionamento com livros
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Accessor para nome completo
     */
    public function getNomeCompletoAttribute()
    {
        return $this->nome . ' ' . $this->sobrenome;
    }
}
