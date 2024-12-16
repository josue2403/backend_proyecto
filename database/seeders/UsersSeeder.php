<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'ci' => '1234567890',
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'email_verified_at' => now(),
            'rol_id' => 1,
            'phone' => '1234567890',
            'birthdate' => '1990-01-01',
            'country' => 'Ecuador',
            'city' => 'Manta',
            'urlPhoto' => 'https://static.nationalgeographicla.com/files/styles/image_3200/public/nationalgeographic_1468962.jpg?w=1600&h=1179',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'ci' => '1234567891',
            'name' => 'Jose',
            'last_name' => 'Donny',
            'email' => 'jose.donny@example.com',
            'email_verified_at' => now(),
            'rol_id' => 2,
            'phone' => '1234567830',
            'birthdate' => '1990-01-01',
            'country' => 'Ecuador',
            'city' => 'Portoviejo',
            'urlPhoto' => 'https://static.vecteezy.com/system/resources/previews/000/290/610/non_2x/administration-vector-icon.jpg',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'ci' => '1234567350',
            'name' => 'Ricardo',
            'last_name' => 'Contreras',
            'email' => 'ricardo.contreras@example.com',
            'email_verified_at' => now(),
            'rol_id' => 3,
            'phone' => '1234553490',
            'birthdate' => '1990-01-01',
            'country' => 'Ecuador',
            'city' => 'Loja',
            'urlPhoto' => 'https://cdn.agenciasinc.es/var/ezwebin_site/storage/images/_aliases/img_1col/reportajes/y-si-tu-perro-pudiera-vivir-cien-anos/9656705-1-esl-MX/Y-si-tu-perro-pudiera-vivir-cien-anos.jpg',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'ci' => '1232347990',
            'name' => 'Farfa',
            'last_name' => 'Dox',
            'email' => 'farfa.dox@example.com',
            'email_verified_at' => now(),
            'rol_id' => 4,
            'phone' => '12345634590',
            'birthdate' => '1990-01-01',
            'country' => 'Ecuador',
            'city' => 'Esmeraldas',
            'urlPhoto' => 'https://kiwiexoticos.b-cdn.net/wp-content/uploads/2023/03/guia-basica-cobayas.jpg',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'ci' => '1229407350',
            'name' => 'Rich',
            'last_name' => 'Moe',
            'email' => 'rich.moe@example.com',
            'email_verified_at' => now(),
            'rol_id' => 4,
            'phone' => '1234567890',
            'birthdate' => '1990-01-01',
            'country' => 'Japan',
            'city' => 'Tokyo',
            'urlPhoto' => 'https://static.nationalgeographicla.com/files/styles/image_3200/public/nationalgeographic_1468962.jpg?w=1600&h=1179',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

