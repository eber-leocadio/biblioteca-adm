<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Lista todos os livros
     */
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category']);

        // Filtros
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%")
                        ->orWhere('sobrenome', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $books = $query->paginate($request->per_page ?? 15);

        return response()->json($books);
    }

    /**
     * Cria um novo livro
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:20',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'ano_publicacao' => 'required|integer|min:1000|max:' . date('Y'),
            'editora' => 'required|string|max:255',
            'numero_paginas' => 'required|integer|min:1',
            'quantidade_total' => 'required|integer|min:1',
            'localizacao' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'nullable|in:disponivel,indisponivel'
        ]);

        $book = Book::create([
            ...$request->all(),
            'quantidade_disponivel' => $request->quantidade_total,
            'status' => $request->status ?? 'disponivel'
        ]);

        return response()->json([
            'message' => 'Livro criado com sucesso',
            'book' => $book->load(['author', 'category'])
        ], 201);
    }

    /**
     * Exibe um livro específico
     */
    public function show($id)
    {
        $book = Book::with(['author', 'category', 'emprestimos.user'])->findOrFail($id);
        
        return response()->json($book);
    }

    /**
     * Atualiza um livro
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|max:20|unique:books,isbn,' . $book->id,
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'ano_publicacao' => 'sometimes|required|integer|min:1000|max:' . date('Y'),
            'editora' => 'sometimes|required|string|max:255',
            'numero_paginas' => 'sometimes|required|integer|min:1',
            'quantidade_total' => 'sometimes|required|integer|min:1',
            'localizacao' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'nullable|in:disponivel,indisponivel'
        ]);

        $book->update($request->all());

        return response()->json([
            'message' => 'Livro atualizado com sucesso',
            'book' => $book->load(['author', 'category'])
        ]);
    }

    /**
     * Remove um livro
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Verifica se há empréstimos ativos
        if ($book->emprestimos()->where('status', 'ativo')->exists()) {
            return response()->json([
                'message' => 'Não é possível excluir um livro com empréstimos ativos'
            ], 400);
        }

        $book->delete();

        return response()->json([
            'message' => 'Livro excluído com sucesso'
        ]);
    }

    /**
     * Lista livros disponíveis para empréstimo
     */
    public function disponveis()
    {
        $books = Book::with(['author', 'category'])
            ->where('status', 'disponivel')
            ->where('quantidade_disponivel', '>', 0)
            ->get();

        return response()->json($books);
    }
}
