<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rol')->insert([
            [
                'rol' => 'Administrador',
                'desc' => 'Administrador del sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rol' => 'Usuario',
                'desc' => 'Usuario cliente común',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rol' => 'Propietario',
                'desc' => 'Propietario de una empresa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rol' => 'Multi-Propietario',
                'desc' => 'Propietario de varias empresas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
