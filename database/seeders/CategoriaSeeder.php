<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\SubCategoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Alimentos',
                'status' => 1,
                'subcategorias' => [
                    'Desayunos', 'Almuerzos', 'Cenas', 'Extras'
                ]
            ],
            [
                'nombre' => 'Bebidas',
                'status' => 1,
                'subcategorias' => [
                    'Jugos Naturales', 'Refrescos', 'Cervezas', 'Café & Té'
                ]
            ],
            [
                'nombre' => 'Postres',
                'status' => 1,
                'subcategorias' => [
                    'Tortas', 'Helados', 'Frutas', 'Repostería', 'Gelatinas'
                ]
            ]
        ];

        foreach ($categorias as $cat) {
            $categoria = Categoria::create([
                'nombre' => $cat['nombre'],
                'status' => $cat['status'],
            ]);

            foreach ($cat['subcategorias'] as $sub) {
                SubCategoria::create([
                    'categoria_id' => $categoria->id,
                    'nombre' => $sub,
                    'status' => 1,
                ]);
            }
        }
    }
}
