<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria usuário de teste
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@biblioteca.com',
        ]);

        // Executa os seeders
        $this->call([
            CategoriesSeeder::class,
            AuthorsSeeder::class,
            BooksSeeder::class,
        ]);
    }
}
