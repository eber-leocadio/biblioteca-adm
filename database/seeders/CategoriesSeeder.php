<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nome' => 'Ficção',
                'descricao' => 'Livros de ficção, romances e literatura'
            ],
            [
                'nome' => 'Não-ficção',
                'descricao' => 'Livros baseados em fatos reais'
            ],
            [
                'nome' => 'Tecnologia',
                'descricao' => 'Livros sobre programação, computação e tecnologia'
            ],
            [
                'nome' => 'História',
                'descricao' => 'Livros sobre história mundial e regional'
            ],
            [
                'nome' => 'Ciência',
                'descricao' => 'Livros sobre ciências exatas e biológicas'
            ],
            [
                'nome' => 'Filosofia',
                'descricao' => 'Livros sobre filosofia e pensamento crítico'
            ],
            [
                'nome' => 'Autoajuda',
                'descricao' => 'Livros de desenvolvimento pessoal'
            ],
            [
                'nome' => 'Biografia',
                'descricao' => 'Biografias e autobiografias'
            ],
            [
                'nome' => 'Infantil',
                'descricao' => 'Livros para crianças e jovens'
            ],
            [
                'nome' => 'Poesia',
                'descricao' => 'Livros de poesia e verso'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
