<?php

use Database\Seeders\CategoriaSeeder;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        Role::create(['name' => 'superAdmin']);
        Role::create(['name' => 'empleado']);
        Role::create(['name' => 'cliente']);
        $cliente = User::create([
            'name' => 'CLIENTE GENERAL',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $cliente->assignRole('cliente');
        // Crear usuarios y asignar roles
        $superAdmin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $superAdmin->assignRole('superAdmin');

        $empleado = User::create([
            'name' => 'Empleado',
            'email' => 'empleado@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $empleado->assignRole('empleado');



        // Llamar a otros seeders
        $this->call([
            CategoriaSeeder::class,
        ]);
    }
}
