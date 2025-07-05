<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Lista todas as categorias
     */
    public function index()
    {
        $categories = Category::with('books')->paginate(15);
        
        return response()->json([
            'message' => 'Categorias listadas com sucesso',
            'data' => $categories
        ]);
    }

    /**
     * Cria uma nova categoria
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categories',
            'descricao' => 'nullable|string',
        ]);

        $category = Category::create($request->all());

        return response()->json([
            'message' => 'Categoria criada com sucesso',
            'data' => $category
        ], 201);
    }

    /**
     * Exibe uma categoria específica
     */
    public function show(Category $category)
    {
        $category->load('books');
        
        return response()->json([
            'message' => 'Categoria encontrada',
            'data' => $category
        ]);
    }

    /**
     * Atualiza uma categoria
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categories,nome,' . $category->id,
            'descricao' => 'nullable|string',
        ]);

        $category->update($request->all());

        return response()->json([
            'message' => 'Categoria atualizada com sucesso',
            'data' => $category
        ]);
    }

    /**
     * Remove uma categoria
     */
    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return response()->json([
                'message' => 'Não é possível excluir categoria que possui livros cadastrados'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categoria excluída com sucesso'
        ]);
    }
}
