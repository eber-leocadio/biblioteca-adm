<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmprestimosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar as rotas de API para sua aplicação. Essas
| rotas são carregadas pelo RouteServiceProvider dentro de um grupo que
| é atribuído ao middleware "api". Aproveite e construa algo incrível!
|
*/

// Rotas públicas (não requerem autenticação)
Route::prefix('v1')->group(function () {
    // Rota de status da API
    Route::get('/status', function () {
        return response()->json([
            'status' => 'OK',
            'message' => 'API da Biblioteca está funcionando',
            'timestamp' => now()->toISOString(),
            'version' => '1.0.0'
        ]);
    });

    // Rotas de autenticação
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Rotas públicas de consulta (sem autenticação)
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/disponveis', [BookController::class, 'disponveis']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
});

// Rotas protegidas (requerem autenticação)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Rotas de usuário autenticado
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Rota para obter informações do usuário autenticado (compatibilidade)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // === ROTAS DE LIVROS ===
    Route::prefix('books')->group(function () {
        Route::post('/', [BookController::class, 'store']);
        Route::put('/{id}', [BookController::class, 'update']);
        Route::delete('/{id}', [BookController::class, 'destroy']);
    });
    
    // === ROTAS DE AUTORES ===
    Route::prefix('authors')->group(function () {
        Route::post('/', [AuthorController::class, 'store']);
        Route::put('/{author}', [AuthorController::class, 'update']);
        Route::delete('/{author}', [AuthorController::class, 'destroy']);
    });
    
    // === ROTAS DE CATEGORIAS ===
    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });
    
    // === ROTAS DE EMPRÉSTIMOS ===
    Route::prefix('emprestimos')->group(function () {
        Route::get('/', [EmprestimosController::class, 'index']);
        Route::post('/', [EmprestimosController::class, 'store']);
        Route::get('/meus', [EmprestimosController::class, 'meus']);
        Route::get('/atrasados', [EmprestimosController::class, 'atrasados']);
        Route::get('/relatorio', [EmprestimosController::class, 'relatorio']);
        Route::get('/{id}', [EmprestimosController::class, 'show']);
        Route::put('/{id}', [EmprestimosController::class, 'update']);
        Route::post('/{id}/devolver', [EmprestimosController::class, 'devolver']);
        Route::post('/{id}/renovar', [EmprestimosController::class, 'renovar']);
    });
});
