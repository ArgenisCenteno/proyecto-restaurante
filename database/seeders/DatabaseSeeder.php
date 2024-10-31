<?php
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

        // Crear usuarios y asignar roles
        $superAdmin = User::create([
            'name' => 'Frank Ruiz',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $superAdmin->assignRole('superAdmin');

        $empleado = User::create([
            'name' => 'Empleado',
            'email' => 'empleado@example.com',
            'password' => Hash::make('1234'),
        ]);
        $empleado->assignRole('empleado');

        $cliente = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
            'password' => Hash::make('1234'),
        ]);
        $cliente->assignRole('cliente');
    }
}
