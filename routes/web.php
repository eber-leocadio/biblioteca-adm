<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar as rotas web para sua aplicação. Essas rotas
| são carregadas pelo RouteServiceProvider e todas serão atribuídas ao
| grupo de middleware "web". Faça algo incrível!
|
*/

// Rota simples para verificar se o Laravel está funcionando
Route::get('/', function () {
    return response()->json([
        'message' => 'API da Biblioteca - Laravel Backend',
        'status' => 'OK',
        'api_routes' => [
            'status' => '/api/v1/status',
            'register' => '/api/v1/register',
            'login' => '/api/v1/login',
            'me' => '/api/v1/me (requer autenticação)',
            'logout' => '/api/v1/logout (requer autenticação)',
        ]
    ]);
});
