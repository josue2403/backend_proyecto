<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run()
    {
        DB::table('rol')->insert([
            ['rol' => 'Administrador', 'desc' => 'Acceso a TODO el sistema.'],
            ['rol' => 'Usuario', 'desc' => 'Usuario cliente común.'],
        ]);
    }
}
