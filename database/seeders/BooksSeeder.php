<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'titulo' => 'Dom Casmurro',
                'isbn' => '9788535902777',
                'descricao' => 'Romance de Machado de Assis que narra a história de Bentinho e Capitu.',
                'ano_publicacao' => 1899,
                'editora' => 'Companhia das Letras',
                'numero_paginas' => 256,
                'quantidade_total' => 5,
                'quantidade_disponivel' => 5,
                'localizacao' => 'Estante A, Prateleira 1',
                'author_id' => 1, // Machado de Assis
                'category_id' => 1, // Ficção
                'status' => 'disponivel'
            ],
            [
                'titulo' => 'A Hora da Estrela',
                'isbn' => '9788520920992',
                'descricao' => 'Último romance de Clarice Lispector, publicado em 1977.',
                'ano_publicacao' => 1977,
                'editora' => 'Rocco',
                'numero_paginas' => 96,
                'quantidade_total' => 3,
                'quantidade_disponivel' => 3,
                'localizacao' => 'Estante A, Prateleira 2',
                'author_id' => 2, // Clarice Lispector
                'category_id' => 1, // Ficção
                'status' => 'disponivel'
            ],
            [
                'titulo' => 'Cem Anos de Solidão',
                'isbn' => '9788535909848',
                'descricao' => 'Romance do escritor colombiano Gabriel García Márquez.',
                'ano_publicacao' => 1967,
                'editora' => 'Companhia das Letras',
                'numero_paginas' => 432,
                'quantidade_total' => 4,
                'quantidade_disponivel' => 4,
                'localizacao' => 'Estante B, Prateleira 1',
                'author_id' => 3, // Gabriel García Márquez
                'category_id' => 1, // Ficção
                'status' => 'disponivel'
            ],
            [
                'titulo' => '1984',
                'isbn' => '9788535914849',
                'descricao' => 'Distopia de George Orwell sobre um regime totalitário.',
                'ano_publicacao' => 1949,
                'editora' => 'Companhia das Letras',
                'numero_paginas' => 416,
                'quantidade_total' => 6,
                'quantidade_disponivel' => 6,
                'localizacao' => 'Estante B, Prateleira 2',
                'author_id' => 4, // George Orwell
                'category_id' => 1, // Ficção
                'status' => 'disponivel'
            ],
            [
                'titulo' => 'Harry Potter e a Pedra Filosofal',
                'isbn' => '9788532511010',
                'descricao' => 'Primeiro livro da série Harry Potter.',
                'ano_publicacao' => 1997,
                'editora' => 'Rocco',
                'numero_paginas' => 264,
                'quantidade_total' => 8,
                'quantidade_disponivel' => 8,
                'localizacao' => 'Estante C, Prateleira 1',
                'author_id' => 5, // J.K. Rowling
                'category_id' => 9, // Infantil
                'status' => 'disponivel'
            ],
            [
                'titulo' => 'O Iluminado',
                'isbn' => '9788581050089',
                'descricao' => 'Romance de terror de Stephen King.',
                'ano_publicacao' => 1977,
                'editora' => 'Suma',
                'numero_paginas' => 512,
                'quantidade_total' => 3,
                'quantidade_disponivel' => 3,
                'localizacao' => 'Estante D, Prateleira 1',
                'author_id' => 6, // Stephen King
                'category_id' => 1, // Ficção
                'status' => 'disponivel'
            ],
            [
                'titulo' => 'Clean Code',
                'isbn' => '9780132350884',
                'descricao' => 'Manual de desenvolvimento de software ágil.',
                'ano_publicacao' => 2008,
                'editora' => 'Prentice Hall',
                'numero_paginas' => 464,
                'quantidade_total' => 4,
                'quantidade_disponivel' => 4,
                'localizacao' => 'Estante E, Prateleira 1',
                'author_id' => 7, // Robert Martin
                'category_id' => 3, // Tecnologia
                'status' => 'disponivel'
            ],
            [
                'titulo' => 'O Alquimista',
                'isbn' => '9788575421936',
                'descricao' => 'Romance de Paulo Coelho sobre um jovem pastor andaluz.',
                'ano_publicacao' => 1988,
                'editora' => 'Planeta',
                'numero_paginas' => 174,
                'quantidade_total' => 7,
                'quantidade_disponivel' => 7,
                'localizacao' => 'Estante F, Prateleira 1',
                'author_id' => 8, // Paulo Coelho
                'category_id' => 1, // Ficção
                'status' => 'disponivel'
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
