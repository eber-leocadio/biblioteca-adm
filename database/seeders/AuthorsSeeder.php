<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'nome' => 'Machado',
                'sobrenome' => 'de Assis',
                'nacionalidade' => 'Brasileira',
                'data_nascimento' => '1839-06-21',
                'biografia' => 'Joaquim Maria Machado de Assis foi um escritor brasileiro, considerado um dos maiores nomes da literatura brasileira.'
            ],
            [
                'nome' => 'Clarice',
                'sobrenome' => 'Lispector',
                'nacionalidade' => 'Brasileira',
                'data_nascimento' => '1920-12-10',
                'biografia' => 'Clarice Lispector foi uma escritora e jornalista brasileira nascida na Ucrânia.'
            ],
            [
                'nome' => 'Gabriel',
                'sobrenome' => 'García Márquez',
                'nacionalidade' => 'Colombiana',
                'data_nascimento' => '1927-03-06',
                'biografia' => 'Gabriel García Márquez foi um escritor, jornalista e Prêmio Nobel de Literatura.'
            ],
            [
                'nome' => 'George',
                'sobrenome' => 'Orwell',
                'nacionalidade' => 'Britânica',
                'data_nascimento' => '1903-06-25',
                'biografia' => 'Eric Arthur Blair, conhecido pelo pseudônimo George Orwell, foi um escritor, jornalista e ensaísta político inglês.'
            ],
            [
                'nome' => 'J.K.',
                'sobrenome' => 'Rowling',
                'nacionalidade' => 'Britânica',
                'data_nascimento' => '1965-07-31',
                'biografia' => 'Joanne Rowling é uma escritora, roteirista e produtora cinematográfica britânica, notória por escrever a série Harry Potter.'
            ],
            [
                'nome' => 'Stephen',
                'sobrenome' => 'King',
                'nacionalidade' => 'Americana',
                'data_nascimento' => '1947-09-21',
                'biografia' => 'Stephen Edwin King é um escritor americano de horror, ficção sobrenatural, suspense, ficção científica e fantasia.'
            ],
            [
                'nome' => 'Robert',
                'sobrenome' => 'Martin',
                'nacionalidade' => 'Americana',
                'data_nascimento' => '1952-12-05',
                'biografia' => 'Robert Cecil Martin, conhecido como Uncle Bob, é um engenheiro de software americano e autor.'
            ],
            [
                'nome' => 'Paulo',
                'sobrenome' => 'Coelho',
                'nacionalidade' => 'Brasileira',
                'data_nascimento' => '1947-08-24',
                'biografia' => 'Paulo Coelho de Souza é um romancista, jornalista e teatrólogo brasileiro.'
            ]
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
