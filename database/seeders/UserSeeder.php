<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário administrador
        User::create([
            'name' => 'Admin',
            'lastname' => 'Sistema',
            'cpf' => '000.000.000-00',
            'email' => 'admin@feitoaqui.com',
            'birthDate' => '1990-01-01',
            'password' => Hash::make('admin123'),
            'socialMedia' => '@admin',
            'is_admin' => true,
        ]);

        // Criar usuários de teste
        User::create([
            'name' => 'João',
            'lastname' => 'Silva',
            'cpf' => '111.222.333-44',
            'email' => 'joao@example.com',
            'birthDate' => '1995-05-15',
            'password' => Hash::make('senha123'),
            'socialMedia' => '@joaosilva',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Maria',
            'lastname' => 'Santos',
            'cpf' => '222.333.444-55',
            'email' => 'maria@example.com',
            'birthDate' => '1988-08-20',
            'password' => Hash::make('senha123'),
            'socialMedia' => '@mariasantos',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Pedro',
            'lastname' => 'Oliveira',
            'cpf' => '333.444.555-66',
            'email' => 'pedro@example.com',
            'birthDate' => '1992-03-10',
            'password' => Hash::make('senha123'),
            'socialMedia' => '@pedrooliveira',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Ana',
            'lastname' => 'Costa',
            'cpf' => '444.555.666-77',
            'email' => 'ana@example.com',
            'birthDate' => '1997-11-25',
            'password' => Hash::make('senha123'),
            'socialMedia' => '@anacosta',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Carlos',
            'lastname' => 'Ferreira',
            'cpf' => '555.666.777-88',
            'email' => 'carlos@example.com',
            'birthDate' => '1985-07-30',
            'password' => Hash::make('senha123'),
            'socialMedia' => null,
            'is_admin' => false,
        ]);
    }
}
