<?php

namespace App\Http\Controllers;

use App\Models\Emprestimos;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class EmprestimosController extends Controller
{
    /**
     * Lista todos os empréstimos
     */
    public function index(Request $request)
    {
        $query = Emprestimos::with(['user', 'book.author', 'book.category']);

        // Filtros
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        if ($request->has('atrasados') && $request->atrasados) {
            $query->atrasados();
        }

        $emprestimos = $query->orderBy('created_at', 'desc')
                           ->paginate($request->per_page ?? 15);

        return response()->json($emprestimos);
    }

    /**
     * Cria um novo empréstimo
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'data_prevista_devolucao' => 'required|date|after:today',
            'observacoes' => 'nullable|string'
        ]);

        $book = Book::findOrFail($request->book_id);

        // Verifica se o livro está disponível
        if (!$book->isDisponivel()) {
            return response()->json([
                'message' => 'Livro não está disponível para empréstimo'
            ], 400);
        }

        // Verifica se o usuário não tem empréstimos em atraso
        $emprestimosAtrasados = Emprestimos::where('user_id', $request->user_id)
                                         ->atrasados()
                                         ->count();

        if ($emprestimosAtrasados > 0) {
            return response()->json([
                'message' => 'Usuário possui empréstimos em atraso'
            ], 400);
        }

        // Verifica se o usuário já não tem o mesmo livro emprestado
        $emprestimoExistente = Emprestimos::where('user_id', $request->user_id)
                                        ->where('book_id', $request->book_id)
                                        ->where('status', 'ativo')
                                        ->exists();

        if ($emprestimoExistente) {
            return response()->json([
                'message' => 'Usuário já possui este livro emprestado'
            ], 400);
        }

        $emprestimo = Emprestimos::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'data_emprestimo' => now(),
            'data_prevista_devolucao' => $request->data_prevista_devolucao,
            'status' => 'ativo',
            'observacoes' => $request->observacoes
        ]);

        // Atualiza a quantidade disponível do livro
        $book->emprestar();

        return response()->json([
            'message' => 'Empréstimo realizado com sucesso',
            'emprestimo' => $emprestimo->load(['user', 'book.author'])
        ], 201);
    }

    /**
     * Exibe um empréstimo específico
     */
    public function show($id)
    {
        $emprestimo = Emprestimos::with(['user', 'book.author', 'book.category'])
                                ->findOrFail($id);
        
        return response()->json($emprestimo);
    }

    /**
     * Atualiza um empréstimo
     */
    public function update(Request $request, $id)
    {
        $emprestimo = Emprestimos::findOrFail($id);

        $request->validate([
            'data_prevista_devolucao' => 'sometimes|required|date|after:today',
            'observacoes' => 'nullable|string'
        ]);

        $emprestimo->update($request->only(['data_prevista_devolucao', 'observacoes']));

        return response()->json([
            'message' => 'Empréstimo atualizado com sucesso',
            'emprestimo' => $emprestimo->load(['user', 'book.author'])
        ]);
    }

    /**
     * Devolve um livro (finaliza empréstimo)
     */
    public function devolver($id)
    {
        $emprestimo = Emprestimos::findOrFail($id);

        if ($emprestimo->status !== 'ativo') {
            return response()->json([
                'message' => 'Este empréstimo já foi finalizado'
            ], 400);
        }

        $emprestimo->devolver();

        return response()->json([
            'message' => 'Livro devolvido com sucesso',
            'emprestimo' => $emprestimo->fresh()->load(['user', 'book.author']),
            'multa' => $emprestimo->multa > 0 ? $emprestimo->multa : null
        ]);
    }

    /**
     * Lista empréstimos do usuário autenticado
     */
    public function meus(Request $request)
    {
        $query = Emprestimos::with(['book.author', 'book.category'])
                           ->where('user_id', $request->user()->id);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $emprestimos = $query->orderBy('created_at', 'desc')
                           ->paginate($request->per_page ?? 15);

        return response()->json($emprestimos);
    }

    /**
     * Lista empréstimos atrasados
     */
    public function atrasados()
    {
        $emprestimos = Emprestimos::with(['user', 'book.author'])
                                 ->atrasados()
                                 ->orderBy('data_prevista_devolucao', 'asc')
                                 ->get();

        return response()->json($emprestimos);
    }

    /**
     * Renova um empréstimo
     */
    public function renovar(Request $request, $id)
    {
        $request->validate([
            'data_prevista_devolucao' => 'required|date|after:today'
        ]);

        $emprestimo = Emprestimos::findOrFail($id);

        if ($emprestimo->status !== 'ativo') {
            return response()->json([
                'message' => 'Não é possível renovar um empréstimo já finalizado'
            ], 400);
        }

        if ($emprestimo->isAtrasado()) {
            return response()->json([
                'message' => 'Não é possível renovar um empréstimo em atraso'
            ], 400);
        }

        $emprestimo->update([
            'data_prevista_devolucao' => $request->data_prevista_devolucao
        ]);

        return response()->json([
            'message' => 'Empréstimo renovado com sucesso',
            'emprestimo' => $emprestimo->fresh()->load(['user', 'book.author'])
        ]);
    }

    /**
     * Relatório de empréstimos
     */
    public function relatorio(Request $request)
    {
        $ativos = Emprestimos::where('status', 'ativo')->count();
        $atrasados = Emprestimos::atrasados()->count();
        $devolvidos = Emprestimos::where('status', 'devolvido')->count();
        $total = Emprestimos::count();

        $multaTotal = Emprestimos::where('multa', '>', 0)->sum('multa');

        return response()->json([
            'total_emprestimos' => $total,
            'emprestimos_ativos' => $ativos,
            'emprestimos_atrasados' => $atrasados,
            'emprestimos_devolvidos' => $devolvidos,
            'multa_total' => $multaTotal
        ]);
    }
}
