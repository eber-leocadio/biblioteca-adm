<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento com empréstimos
     */
    public function emprestimos()
    {
        return $this->hasMany(Emprestimos::class);
    }

    /**
     * Empréstimos ativos do usuário
     */
    public function emprestimosAtivos()
    {
        return $this->emprestimos()->where('status', 'ativo');
    }

    /**
     * Verifica se o usuário tem empréstimos em atraso
     */
    public function hasEmprestimosAtrasados()
    {
        return $this->emprestimos()
                   ->where('status', 'ativo')
                   ->where('data_prevista_devolucao', '<', now())
                   ->exists();
    }

    /**
     * Verifica se o usuário pode fazer empréstimo
     */
    public function podeEmprestar()
    {
        $emprestimosAtivos = $this->emprestimosAtivos()->count();
        $emprestimosAtrasados = $this->emprestimos()
            ->where('status', 'ativo')
            ->where('data_prevista_devolucao', '<', now())
            ->count();

        return $emprestimosAtivos < 3 && $emprestimosAtrasados === 0;
    }
}
