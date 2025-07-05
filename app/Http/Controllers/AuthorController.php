<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Lista todos os autores
     */
    public function index()
    {
        $authors = Author::with('books')->paginate(15);
        
        return response()->json([
            'message' => 'Autores listados com sucesso',
            'data' => $authors
        ]);
    }

    /**
     * Cria um novo autor
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'nacionalidade' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
            'biografia' => 'nullable|string',
        ]);

        $author = Author::create($request->all());

        return response()->json([
            'message' => 'Autor criado com sucesso',
            'data' => $author
        ], 201);
    }

    /**
     * Exibe um autor específico
     */
    public function show(Author $author)
    {
        $author->load('books');
        
        return response()->json([
            'message' => 'Autor encontrado',
            'data' => $author
        ]);
    }

    /**
     * Atualiza um autor
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'nacionalidade' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
            'biografia' => 'nullable|string',
        ]);

        $author->update($request->all());

        return response()->json([
            'message' => 'Autor atualizado com sucesso',
            'data' => $author
        ]);
    }

    /**
     * Remove um autor
     */
    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return response()->json([
                'message' => 'Não é possível excluir autor que possui livros cadastrados'
            ], 400);
        }

        $author->delete();

        return response()->json([
            'message' => 'Autor excluído com sucesso'
        ]);
    }
}
